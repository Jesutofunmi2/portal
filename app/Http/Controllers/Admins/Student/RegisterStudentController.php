<?php

namespace App\Http\Controllers\Admins\Student;

use App\Http\Controllers\Controller;
use App\Imports\StudentsImport;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\ImageManager;

class RegisterStudentController extends Controller
{
    //
    protected $admin;

    protected $student;

    public function __construct(StudentRepositoryInterface $student, AdminRepositoryInterface $admin) 
    {

        $this->middleware('auth:school_api');

        $this->admin = $admin;

        $this->student = $student;

    }

    public function index(Request $request)
    {
        
        if($this->permissionDeny('create-student')){
           return response()->json([
            'message' => 'Permission Denied'
           ],403);
        }
        
        $setStudent = $this->student->setStudent();

        $messages = [
            'firstname.unique' => 'Another student with the same First Name and Surname exists in the selected Session',
            'lga_id.required' => 'The Lga field is required.',
            'house_id.required' => 'The House field is required.',
            'class_id.required' => 'The Class field is required.',
            'class_arm_id.required' => 'The Class Arm field is required.',
            'dob.required' => 'The Date of Birth field is required',
            'dob.date_format' => 'The Date of birth field does not match the format YYYY-mm-dd',
        ];

        $rules = [
            'surname' => 'required|min:3',
            'firstname' => ['required', 'min:3', 
                Rule::unique('students')->where(function ($query) use ($request) {
                    return $query->where('surname', $request->input('surname'))
                    ->where('firstname', $request->input('firstname'))
                    ->where('session', $request->input('session'));
                }),
            ],
            'dob' => 'required|date_format:Y-m-d',
            'gender' => ['required','regex:/(Male|Female)/'],
            'country' => 'required',
            'address' => 'required|min:10',
            'lga_id' => 'required|integer|not_in:0',
            'house_id' => 'required|integer|not_in:0',
            'religion' => ['required','regex:/(Christian|Muslim|Traditional)/'],
            'password' => 'required|alpha_num|min:6|confirmed',
            'password_confirmation' => 'required|alpha_num|min:6',
            'parent_fullname' => 'required',
            'parent_address' => 'required',
            'parent_email' => 'required|email',
            'parent_phone' => 'required|regex:(234?)|digits:13',
            'session' => 'required|digits:4',
            'term' => ['required','regex:/(First|Second|Third)/'],
            'class_id' => 'required|integer',
            'class_arm_id' => 'required|integer',
            'phone' => 'nullable|regex:(234?)|digits:13',
            'blood_group' => ['required','regex:/(A+|A-|B+|B-|AB+|AB-|O+|O-)/'],
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

        
        // we adjust the lga_id to fit in to the usual regnum format
        $school_lga_id = $school_lga_id > 579 ? $school_lga_id - 569 : $school_lga_id - 568;

        $regnum_digit = $this->student->getNextRegNum($request->input('session'), $school_id);
        $regnum = str_pad($school_lga_id, 2, "0", STR_PAD_LEFT).substr($request->input('session'), 2, 2).str_pad($school_id, 3, "0", STR_PAD_LEFT).str_pad($regnum_digit, 3, "0", STR_PAD_LEFT);

        $details = [
            'surname' => $request->input('surname'),
            'firstname' => $request->input('firstname'),
            'middlename' => $request->input('middlename'),
            'regnum' => $regnum,
            'regnum_digit' => $regnum_digit,
            'dob' => $request->input('dob'),
            'gender' => $request->input('gender'),
            'country' => $request->input('country'),
            'address' => $request->input('address'),
            'state_id' => env('STATE_ID'),
            'lga_id' => $request->input('lga_id'),
            'house_id' => $request->input('house_id'),
            'religion' => $request->input('religion'),
            'password' => Hash::make($request->input('password')),
            'parent_fullname' => $request->input('parent_fullname'),
            'parent_address' => $request->input('parent_address'),
            'parent_email' => $request->input('parent_email'),
            'parent_phone' => $request->input('parent_phone'),
            'phone' => $request->input('phone'),
            'status' => 0,
            'school_id' => $school_id,
            'session' => $request->input('session'),
            'blood_group' => $request->input('blood_group'),       
        ];

        if ($request->hasFile('passport')) {
            $extension = $request->file('passport')->extension();
            $file_name = 'images/passports/students/'.$school_name.'/'.bin2hex(random_bytes(16)).'.'.$extension;
            $manager = new ImageManager(array('driver' => 'gd'));
            $image = $manager->make($_FILES['passport']['tmp_name']);
            // Resizing the images
            $image->resize(200,200)->encode(null,75);
            // Storing the images...
            $path = Storage::put($file_name, (string) $image );
            // Getting the URL....
            $url =  '/'.$file_name;
            $details['passport'] = $url;
        }
        
        $student = $setStudent->create($details);

        //Create student and class_arm relationship
        DB::table('classarm_student')->insert([
            'student_id' => $student->id,
            'classarm_id' => $request->input('class_arm_id'),
            'session' => $request->input('session'),
            'term' => $request->input('term'),
            'class_id' => $request->input('class_id')
        ]);

        return response()->json([
            'data' => [
                'message' => 'Student Registered successfully'
            ]
        ]);

    }

    public function batchRegistration(Request $request)
    {
        if($this->permissionDeny('create-student')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
        }

        $rules = [
            'file' => 'required|file|mimetypes:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel',
            'session' => 'required|integer',
            'term' => ['required','regex:/(First|Second|Third)/'],
            'class_id' => 'required|integer',
            'classarm_id' => 'required|integer',
        ];

        $messages = [
            'file.required' => 'Please upload an appropriate file',
            'file.file' => 'Please upload an appropriate file',
            'file.mimetypes' => 'Only Microsoft Excel spreadsheets are allowed',
            'class_id.required' => 'Please select a Class',
            'classarm_id.required' => 'Please select a Class Arm',
        ];

        $this->validate($request, $rules, $messages);

        //Get the school admin id
        $admin = Auth::guard('school_api')->user();
        //Get the school_id
        $school_id = $admin->school_id;
        //Get School Name
        $school = DB::table('schools_new')->where('id', $school_id)->first();
        $school_lga_id = $school->lga_id;

        $session = $request->input('session');
        $term = $request->input('term');
        $class_id = $request->input('class_id');
        $classarm_id = $request->input('classarm_id');

        if ($request->hasFile('file')) {

            $regnum_digit = $this->student->getNextRegNum($session, $school_id);

            $data = [
                'session' => $session,
                'term' => $term,
                'class_id' => $class_id,
                'classarm_id' => $classarm_id,
                'regnum_digit' => $regnum_digit,
                'school_id' => $school_id,
                'school_lga_id' => $school_lga_id,
            ];

            $import = new StudentsImport($data);
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
                    'message' => 'Batch Student Registration complete',
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
