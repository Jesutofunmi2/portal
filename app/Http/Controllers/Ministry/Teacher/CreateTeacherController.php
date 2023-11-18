<?php

namespace App\Http\Controllers\Ministry\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Gate;
use Illuminate\Support\Facades\Hash;
use App\Repositories\Interfaces\TeacherRepositoryInterface;
use App\Repositories\Interfaces\SubjectRepositoryInterface;
use Excel;
use App\Http\Helper\GeneralHelper;
use App\Http\Helper\ExcelHelper;
use App\Models\Teacher\Teacher;
use Illuminate\Support\Carbon;

class CreateTeacherController extends Controller 
{
    protected $teachers;

    protected $subjects;

    public function __construct(TeacherRepositoryInterface $teachers,
                                SubjectRepositoryInterface $subjects) 
    {
        $this->teachers=$teachers;
        $this->subjects = $subjects;

        $this->middleware('auth:ministry_api');
    }
    public function createSingleTeacher(Request $request)
    {
        if($this->permissionDeny('create-teacher')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
         }

         $teacher = $this->teachers->setTeacher();

        $teacher::$rules['school_id'] = 'required|integer';

        $this->validate($request, $teacher::$rules);

        $session = $request->input('session');
        $request->password = Hash::make($request->password);

        $get_staff_no_session = $this->teachers->getNextStaffDigit($session, $request->school_id);

        $request->staff_no = env('STATE_NAME').'/'.str_pad($request->school_id, 4, 0, STR_PAD_LEFT).'/STAFF/'.$session.'/'.str_pad($get_staff_no_session, 4, 0, STR_PAD_LEFT);
        $request->staff_no_digit = $get_staff_no_session;

        $check_teacher = $this->teachers->setTeacher()
                                ->where('staff_no', $request->staff_no)
                                ->count();
        if(!$check_teacher){

            $staff = $teacher->create([
                'title' => $request->title,
                'surname' => $request->surname,
                'firstname' => $request->firstname,
                'middlename' => $request->middlename,
                'school_id' => $request->school_id,
                'staff_no' => $request->staff_no,
                'staff_no_digit' => $request->staff_no_digit,
                'qualification' => $request->qualification,
                'gender' => $request->gender,
                'address' => $request->address,
                'email' => $request->email,
                'phone' => $request->phone,
                'status' => 0,
                'session' => $request->session,
                'state_id' => $request->state_id,
                'lga_id' => $request->lga_id,
                'password' => $request->password,
                'next_of_kins' => $request->next_of_kins,
                'next_of_kins_address' => $request->next_of_kins_address,
                'next_of_kins_phone' => $request->next_of_kins_phone,
                'next_of_kins_email' => $request->next_of_kins_email,
                'health_status' => $request->health_status,
                'extra_curricular_activites' => $request->extra_curricular_activites,
                'health_status_desc' => $request->health_status_desc ,
                'marital_status' => $request->marital_status,
            ]);
            $staff->subjects()->attach($request->subjects, ['school_id' => $request->school_id]);

            return response()->json([
                'data' => [
                    'message' => 'Teacher created successfully'
                ]
            ]);
        }
        else {
            return response()->json([
                'data' => [
                    'message' => 'The generated Staff ID already exist.'
                ]
                ],409);
        }
       
    }

    public function createBatchTeacher(Request $request)
    {
        if($this->permissionDeny('create-teacher')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
        }

        $teacher = $this->teachers->setTeacher();

        $teacher::$ruleBatch['school_id'] = 'required|integer';

        $this->validate($request, $teacher::$ruleBatch);
            if($request->hasFile('batch_file')){
                $session = $request->input('session');
                $std_count = $this->teachers->getNextStaffDigit($session, $request->school_id);
                $path = $request->file('batch_file')->getRealPath();
                $ext = $request->file('batch_file')->getClientOriginalExtension();
                $duplicacy = array();
                $insert = array();
                $email_checker = array();
                $phone_checker = array();
                $row_counter = 2;
                $data = Excel::toCollection(new ExcelHelper ,$path);
            
                $school_id = $request->school_id;

                if(!empty($data[0]) && $data[0]->count()){

                    foreach ($data[0] as $key => $value) {
                            
                            $emailTeacherVerify = Teacher::where('school_id', $school_id)
                                            ->where('email', strtolower(trim($value['email'])))
                                            ->first();
                                            
                            $phoneTeacherVerify = Teacher::where('school_id', $school_id)
                                            ->where('phone', trim($value['phone']))
                                            ->first();

                            $emailTeacherAllVerify = Teacher::where('email', strtolower(trim($value['email'])))
                                            ->first();
                                            
                            $phoneTeacherAllVerify = Teacher::where('phone', trim($value['phone']))
                                            ->first();

                                if(empty($emailTeacherVerify->id)){
                                    if(empty($phoneTeacherVerify->id)){
                                        if(empty($emailTeacherAllVerify->id)){
                                            if(empty($phoneTeacherAllVerify->id)){
                                                ///// ALL CLEAR /////

                                                if(in_array(trim($value['phone']), $phone_checker) || empty(trim($value['phone']))){
                                                    $duplicacy[] = 'Teacher\'s phone in row '.$row_counter.' already exist in the upload file OR phone field is empty';
                                                }
                                                else
                                                {
                                                    if(in_array($value['email'], $email_checker) || empty($value['email']))
                                                    {
                                                        $duplicacy[] = 'Teacher\'s email in row '.$row_counter.' already exist in the upload file OR email field is empty';
                                                    }
                                                    else{
                                                        $staff_no = env('STATE_NAME').'/'.str_pad($school_id, 4, 0, STR_PAD_LEFT).'/STAFF/'.$session.'/'.str_pad($std_count, 4, 0, STR_PAD_LEFT);
                                                        $teacher_check_row = $this->teachers->setTeacher()
                                                            ->where('staff_no', $staff_no)
                                                            ->count();
                                                        
                                                        if($teacher_check_row == 0){ 
                                                            
                                                            if(empty($value['surname']) || empty($value['firstname']) || empty($value['phone']) || empty($value['email']) || empty($value['password'])){
                                                                $duplicacy[] = 'Either teacher\'s surname, firstname, middlename, phone, email or password in row '.$row_counter.' is empty';
                                                            }else{
                                                                
                                                            $insert[] = [
                                                                'staff_no' => $staff_no,
                                                                'staff_no_digit' => $std_count,
                                                                'title' => $value['title'],
                                                                'surname' => $value['surname'],
                                                                'firstname' => $value['firstname'],
                                                                'middlename' => $value['middlename'],
                                                                'marital_status' => $value['marital_status'],
                                                                'phone' => trim($value['phone']),
                                                                'gender' => $value['gender'],
                                                                'email' => strtolower(trim($value['email'])),
                                                                'address' => $value['address'],
                                                                'state_id' => 0,
                                                                'lga_id' => 0,
                                                                'status' => 0,
                                                                'next_of_kins' => $value['next_of_kins'],
                                                                'next_of_kins_address' => $value['next_of_kins_address'],
                                                                'next_of_kins_phone' => $value['next_of_kins_phone'],
                                                                'next_of_kins_email' => $value['next_of_kins_email'],
                                                                'password' => Hash::make($value['password']),
                                                                'session' => $session,
                                                                'qualification' => $value['qualification'],
                                                                'health_status' => $value['health_status'],
                                                                'school_id' => $school_id,
                                                                'health_status_desc' => $value['health_status_description'],
                                                                'extra_curricular_activites' => $value['extra_curricular_activities'],
                                                                'created_at' => Carbon::now(),
                                                                'updated_at' => Carbon::now()
                
                                                                ];
                
                                                                $email_checker[] = $value['email'];
                                                                $phone_checker[] = trim($value['phone']);
                                                                
                                                            }
                                                        }
                                                            else{
                                                                $duplicacy[] = 'Teacher\'s staff no ('.$staff_no.') in '.$row_counter.' already exist'; 
                                                            }
                                                        }//
                                                } 
                                                
                                                ///// ALL CLEAR /////
                                            }
                                            else{
                                                $exist_school_name = GeneralHelper::getSchoolName($phoneTeacherAllVerify->school_id);
                                                $duplicacy[] = $value['phone'].' already exist in another School ('.$exist_school_name.')';
                                            }
                                        }
                                        else{
                                            $exist_school_name = GeneralHelper::getSchoolName($emailTeacherAllVerify->school_id);
                                            $duplicacy[] = $value['email'].' already exist in another School ('.$exist_school_name.')';
                                        }
                                    }else{
                                        $duplicacy[] = $value['phone'].' already exist, register with another phone number';
                                    }
                                    
                                }else{
                                    $duplicacy[] = $value['email'].' already exist, register with another email address';
                                }


                            $std_count++;

                            $row_counter++;
                    }//end loop
                }
                                            
                if(!empty($insert)){
                    $teacher->insert($insert);

                    return response()->json([
                        'data' => [
                            'message' => 'Successfully inserted '.count($insert).' Teachers',
                            'duplicacy' => $duplicacy,
                        ]
                    ]);

                }else{

                    return response()->json([
                        'data' => [
                            'message' => 'Empty, No data is added',
                            'duplicacy' => $duplicacy,
                        ]],400);
                }
            }   
    }

    protected function permissionDeny($ability){
        Auth::shouldUse('ministry_api');
        return Gate::denies($ability);
    }
}
