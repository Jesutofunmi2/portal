<?php

namespace App\Http\Controllers\Ministry\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use App\Repositories\Interfaces\ClassArmRepositoryInterface;
use App\Repositories\Interfaces\StudentHouseRepositoryInterface;
use App\Repositories\Interfaces\ClassRepositoryInterface;
use App\Repositories\Interfaces\SchoolRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Auth;
use Gate;
use Hash;


class EditStudentController extends Controller
{
    protected $students;

    protected $classes;

    protected $school_houses;

    protected $class_arms;

    protected $school;

    public function __construct(StudentRepositoryInterface $students,
                                ClassArmRepositoryInterface $class_arms,
                                StudentHouseRepositoryInterface $school_houses,
                                ClassRepositoryInterface $classes,
                                SchoolRepositoryInterface $school
                                ) 
    {
        $this->students = $students;

        $this->classes = $classes;

        $this->school_houses = $school_houses;

        $this->class_arms = $class_arms;

        $this->school = $school;

        $this->middleware('auth:ministry_api');
    }

    public function index($id=null)
    {
        if($this->permissionDeny('edit-student')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
        }

        if(!is_numeric($id)){
            return response()->json([
                'data' => [
                    'message' => 'Invalid ID'
                ]
            ]);
        }


        $student = $this->students->find($id);

        $student_class =  $student->classarms()->wherePivot('session', '=',$student->session)
                ->orderBy('term', 'desc')
                ->first();

        $classes = $this->classes->setClass()
                                ->where('school_id', $student->school_id)
                                ->get();
                                
        $class_arms = $this->class_arms->setClassArms()
                                ->where('school_id', $student->school_id)
                                ->get();

        $school_houses = $this->school_houses->setSchoolHouse()
                                ->where('school_id', $student->school_id)
                                ->get();
                                
        $school = $this->school->setSchool()
                                ->where('id',$student->school_id)
                                ->first(['id','name','lga_id']);

        return response()->json([
            'data' => [
                'student' => $student,
                'student_class' => $student_class,
                'classes' => $classes,
                'class_arms' => $class_arms,
                'school_houses' => $school_houses,
                'school' => $school
            ]
        ]);

        //return new ShowTeacherResource($teacher);

    }

    public function update(Request $request, $id='')
    {
        if($this->permissionDeny('edit-teacher')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
        }

        if(!is_numeric($id)){
            return response()->json([
                'data' => [
                    'message' => 'Invalid ID'
                ]
            ]);
        }

        $student_update = $this->students->find($id);

        $student = $this->students->setStudent();

        $student::$rules['password'] = 'sometimes|alpha_num|min:6|confirmed';
        $student::$rules['password_confirmation'] = 'sometimes|alpha_num|min:6';
        $student::$rules['parent_email'] = '';

        $this->validate($request, $student::$rules);

        $regnum = $request->regnum;
        $digit = $request->regnum_digit;

        foreach ($request->all() as $key => $value) {
            if(!in_array($key, array('password_confirmation', 'school_state_id', 'school_lga_id')) && !empty($value)){
                    if($key == 'password' && !empty($value)){
                        $insert[$key] = Hash::make($value);
                    }elseif($key == 'school_id'){
                        if($student_update->school_id != $value ){
                            $prefix = $this->students->getRegNumPrefix($request->session, $request->school_id);
                            $digit = str_pad($this->students->getNextRegNum($request->session, $request->school_id), 3, 0, STR_PAD_LEFT);
                            $regnum = $prefix.$digit;
                            $insert['school_id'] = $value;
                        }
                    }elseif(in_array($key, array('term','class_id','class_arm_id'))){
                        continue;
                    }else{
                        $insert[$key] = $value;
                    }
                }
        }

        $insert['regnum'] = $regnum ;
        $insert['regnum_digit'] = $digit ;
        $student_update->update($insert);

        $exit_student_class = \DB::table('classarm_student')
                                    ->select('student_id')
                                    ->where(['classarm_id' => $request->class_arm_id,
                                              'student_id' => $id,
                                              'term' => $request->term,
                                              'session' => $request->session
                                            ])
                                    ->get();
        

            if(collect($exit_student_class)->count() == 0){
                $exit= \DB::table('classarm_student')
                ->where(['student_id' => $id,
                        'session' => $request->session,
                        'term' => $request->term
                        ])
                ->delete();

            $student_update->classarms()->attach(
                $request->input('class_arm_id'), 
                ['session' => $request->input('session'), 
                'term' => $request->input('term'),
                'class_id' => $request->input('class_id')]);
        }

    return response()->json([
        'data' => [
            'message' => 'Student Updated successfully'
        ]
    ]);




    }

    protected function permissionDeny($ability){
        Auth::shouldUse('ministry_api');
        return Gate::denies($ability);
    }
}
