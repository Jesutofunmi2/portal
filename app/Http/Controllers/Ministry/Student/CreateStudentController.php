<?php

namespace App\Http\Controllers\Ministry\Student;

use App\Http\Controllers\Controller;
use App\Imports\StudentsImport;
use App\Repositories\Interfaces\ClassArmRepositoryInterface;
use App\Repositories\Interfaces\ClassRepositoryInterface;
use App\Repositories\Interfaces\StudentHouseRepositoryInterface;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class CreateStudentController extends Controller 
{
    protected $students;

    protected $house;

    protected $class_arms;

    protected $classes;

    public function __construct(StudentRepositoryInterface $student,
                                StudentHouseRepositoryInterface $house,
                                ClassArmRepositoryInterface $class_arm, 
                                ClassRepositoryInterface $classes) 
    {
        $this->students = $student;

        $this->school_houses = $house;

        $this->class_arms = $class_arm;

        $this->classes = $classes;


        $this->middleware('auth:ministry_api');
    }
    public function createSingleStudent(Request $request)
    {
        if($this->permissionDeny('create-student')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
         }

        $student = $this->students->setStudent();

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

        $prefix = $this->students->getRegNumPrefix($request->session, $request->school_id);
        $digit = str_pad($this->students->getNextRegNum($request->session, $request->school_id), 3, 0, STR_PAD_LEFT);
        $regnum = $prefix.$digit;

        $student_id = $student->create([
            'surname' => $request->input('surname'),
            'firstname' => $request->input('firstname'),
            'middlename' => $request->input('middlename'),
            'regnum' => $regnum,
            'regnum_digit' => $digit,
            'school_id' => $request->input('school_id'),
            'dob'=> $request->input('dob'),
            'gender'  => $request->input('gender'),
            'country' => $request->input('country'),
            'address' => $request->input('address'),
            'state_id'=> $request->input('state_id'),
            'lga_id' => $request->input('lga_id'),
            'religion' => $request->input('religion'),
            'password' => Hash::make($request->input('passwod')),
            'parent_fullname' => $request->input('parent_fullname'),
            'parent_address' => $request->input('parent_address'),
            'parent_email' => $request->input('parent_email'),
            'parent_phone' => $request->input('parent_phone'),
            'session'  => $request->input('session'),
            'house_id' => $request->input('house_id'),
            'phone' => $request->input('phone'),
            'status' => 0,
            'blood_group' => $request->input('blood_group'),
           ]);


        $student_id->classarms()->attach($request->input('class_arm_id'), ['session' => $request->input('session'), 'term' => $request->input('term'), 'class_id' => $request->input('class_id')]);

        return response()->json([
            'data' => [
                'message' => 'Student Registered successfully'
            ]
        ]);
    }

    public function createBatchStudent(Request $request)
    {

        if($this->permissionDeny('create-student')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
         }

         $rules = [
            'batch_file' => 'required|file|mimetypes:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel',
            'session' => 'required|integer',
            'term' => ['required','regex:/(First|Second|Third)/'],
            'class_id' => 'required|integer',
            'class_arm_id' => 'required|integer',
            'school_id' => 'required|integer'
        ];

        $messages = [
            'batch_file.required' => 'Please upload an appropriate file',
            'batch_file.file' => 'Please upload an appropriate file',
            'batch_file.mimetypes' => 'Only Microsoft Excel spreadsheets are allowed',
            'class_id.required' => 'Please select a Class',
            'class_arm_id.required' => 'Please select a Class Arm',
        ];

        $this->validate($request, $rules, $messages);

        $school_id = $request->input('school_id');
        //Get School Name
        $school = DB::table('schools_new')->where('id', $school_id)->first();
        $school_lga_id = $school->lga_id;

        $session = $request->input('session');
        $term = $request->input('term');
        $class_id = $request->input('class_id');
        $classarm_id = $request->input('class_arm_id');

        if ($request->hasFile('batch_file')) {

            $regnum_digit = $this->students->getNextRegNum($session, $school_id);

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
            $import->import(request()->file('batch_file'));

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
        Auth::shouldUse('ministry_api');
        return Gate::denies($ability);
    }
}
