<?php

namespace App\Http\Controllers\Admins\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\TeacherRepositoryInterface;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use App\Imports\TeachersImport;
use Auth;
use Gate;

class RegisterTeacherController extends Controller
{
    //
    protected $admin;

    protected $teacher;

    public function __construct(TeacherRepositoryInterface $teacher, AdminRepositoryInterface $admin) 
    {

        $this->middleware('auth:school_api');

        $this->admin = $admin;

        $this->teacher = $teacher;

    }

    public function index(Request $request)
    {
        
        if($this->permissionDeny('create-teacher')){
           return response()->json([
            'message' => 'Permission Denied'
           ],403);
        }
        
        $setTeacher = $this->teacher->setTeacher();

        $messages = [
            'lga_id.required' => 'The Lga field is required.',
        ];

        $rules = [
            'title' => 'required|min:2',
            'surname' => 'required|min:3',
            'firstname' => 'required|min:3',
            'qualification' => 'required',
            'gender' => ['required','regex:/^(Male|Female)/'],
            'marital_status' => ['required','regex:/^(Single|Married|Divorce)/'],
            'address' => 'required|min:10',
            'email' => 'required|email|unique:teachers,email',
            'phone' => 'required|regex:(234?)',
            'session' => 'required|integer|digits:4',
            'lga_id' => 'required|integer',
            'subjects' => 'required',
            'password' => 'required|alpha_num|min:6|confirmed',
            'password_confirmation' => 'required|alpha_num|min:6',
            'next_of_kins' => 'required|min:10',
            'next_of_kins_address' => 'required|min:10',
            'next_of_kins_phone' => 'required|regex:(234?)',
            'next_of_kins_email' => 'sometimes|email',
            'health_status' => ['required', 'regex:/(Normal|Disable)/'],
            'health_status_desc' => 'required|min:3'
        ];

        $this->validate($request, $rules, $messages);

        //Get the school admin id
        $admin_id = Auth::guard('school_api')->id();
        //Get the school_id
        $school_id = $this->admin->find($admin_id)->school_id;
        //Get School Name
        $school_name = DB::table('schools_new')->where('id', $school_id)->value('name');
        $state_id = env('STATE_ID');
        $state = DB::table('states')
        ->where('id', $state_id)
        ->value('name');

        $staff_no_digit = $this->teacher->getNextStaffDigit($request->input('session'), $school_id);
        $staff_no = strtoupper($state).'/'.str_pad($school_id, 4, 0, STR_PAD_LEFT).'/STAFF/'.$request->input('session').'/'.str_pad($staff_no_digit, 4, "0", STR_PAD_LEFT);
        
        $details = [
            'surname' => $request->input('surname'),
            'firstname' => $request->input('firstname'),
            'middlename' => $request->input('middlename'),
            'staff_no' => $staff_no,
            'staff_no_digit' => $staff_no_digit,
            'email' => $request->input('email'),
            'gender' => $request->input('gender'),
            'title' => $request->input('title'),
            'address' => $request->input('address'),
            'state_id' => $state_id,
            'lga_id' => $request->input('lga_id'),
            'qualification' => $request->input('qualification'),
            'health_status' => $request->input('health_status'),
            'health_status_desc' => $request->input('health_status_desc'),
            'password' => Hash::make($request->input('password')),
            'next_of_kins' => $request->input('next_of_kins'),
            'next_of_kins_address' => $request->input('next_of_kins_address'),
            'next_of_kins_email' => $request->input('next_of_kins_email'),
            'next_of_kins_phone' => $request->input('next_of_kins_phone'),
            'phone' => $request->input('phone'),
            'status' => 0,
            'school_id' => $school_id,
            'session' => $request->input('session'),
            'marital_status' => $request->input('marital_status'), 
            'extra_curricular_activites' => $request->input('extra_curricular_activites'),      
        ];

        if ($request->hasFile('passport')) {
            $extension = $request->file('passport')->extension();
            $file_name = 'images/passports/teachers/'.$school_name.'/'.uniqid().'.'.$extension;
            $manager = new ImageManager(array('driver' => 'gd'));
            $image = $manager->make($_FILES['passport']['tmp_name']);
            // Resizing the images
            $image->resize(200,200)->encode(null,75);
            // Storing the images...
            $path = \Storage::put($file_name, (string) $image );
            // Getting the URL....
            $url =  '/'.$file_name;
            $details['passport'] = $url;
        }

        $subjects = json_decode($request->subjects);
        $teacher = $setTeacher->create($details);        

        //Create teacher and subject relationship
        foreach ($subjects as $subj) {
            DB::table('subject_teacher')->insert([
                'teacher_id' => $teacher->id,
                'subject_id' => $subj,
                'school_id' => $school_id,
            ]);
        }

        return response()->json([
            'data' => [
                'message' => 'Teacher Registered successfully'
            ]
        ]);

    }

    public function batchRegistration(Request $request)
    {
        if($this->permissionDeny('create-teacher')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
        }

        $rules = [
            'file' => 'required|file|mimetypes:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel',
            'session' => 'required|integer',
        ];

        $messages = [
            'file.required' => 'Please upload an appropriate file',
            'file.file' => 'Please upload an appropriate file',
            'file.mimetypes' => 'Only Microsoft Excel spreadsheets are allowed',
        ];

        $this->validate($request, $rules, $messages);

        //Get the school admin id
        $admin_id = Auth::guard('school_api')->id();
        //Get the school_id
        $school_id = $this->admin->find($admin_id)->school_id;
        //Get School Name
        $school = DB::table('schools_new')->where('id', $school_id)->first();
        $school_name = $school->name;
        $school_lga_id = $school->lga_id;
        $state_id = env('STATE_ID');
        $state = DB::table('states')
        ->where('id', $state_id)
        ->value('name');

        $session = $request->input('session');

        if ($request->hasFile('file')) {

            $staff_no_digit = $this->teacher->getNextStaffDigit($session, $school_id);
            $staff_no = strtoupper($state).'/'.str_pad($school_id, 4, 0, STR_PAD_LEFT).'/STAFF/'.$request->input('session').'/'.str_pad($staff_no_digit, 4, "0", STR_PAD_LEFT);
             
            $data = [
                'session' => $session,
                'staff_no_digit' => $staff_no_digit,
                'school_id' => $school_id,
                'state' => $state,
            ];

            $import = new TeachersImport($data);
            $import->import(request()->file('file'));

            $failures[] = [];
            $row = 0;
            foreach ($import->failures() as $failure) {
                $failures[$row]['row'] = $failure->row(); // row that went wrong
                $failures[$row]['attrib'] = $failure->attribute(); // either heading key (if using heading row concern) or column index
                $failures[$row]['errors'] = $failure->errors(); // Actual error messages from Laravel validator
                $row++;
           }

            $errors = $import->errors();

            return response()->json([
                'data' => [
                    'message' => 'Batch Teacher Registration complete',
                    'failures' => $failures,
                    'errors' => $errors,
                ]
            ]);
            
        }
    } 

    protected function permissionDeny($ability){
        Auth::shouldUse('school_api');
        return Gate::denies($ability);
    }
}
