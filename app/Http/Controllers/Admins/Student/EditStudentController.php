<?php

namespace App\Http\Controllers\Admins\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\StudentResource;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\ImageManager;

class EditStudentController extends Controller
{
    //
    protected $student;

    protected $admin;

    public function __construct(StudentRepositoryInterface $student, AdminRepositoryInterface $admin)
        {

        $this->middleware('auth:school_api');

        $this->student = $student;

        $this->admin = $admin;

    }

    public function index($id = null)
    {
        
        if($this->permissionDeny('edit-student')){
           return response()->json([
            'message' => 'Permission Denied'
           ],403);
        }
        
        $student = $this->student->find($id);

        return new StudentResource($student);

    }

    public function editFloating($id = null)
    {
        
        if($this->permissionDeny('edit-student')){
           return response()->json([
            'message' => 'Permission Denied'
           ],403);
        }
        
        $student = $this->student->find($id);

        return new StudentResource($student);

    }

    public function update(Request $request, $id = null)
    {
        $setStudent = $this->student->find($id);

        if($setStudent){
    
            $messages = [
                'firstname.unique' => 'Another student with the same First Name and Surname exists in the selected Session',
                'lga_id.required' => 'The Lga field is required.',
                'dob.date_format' => 'The Date of birth field does not match the format YYYY-mm-dd',
                'house_id.integer' => 'Select a House', 
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
                'dob' => 'nullable|date_format:Y-m-d',
                'gender' => ['required','regex:/(Male|Female)/'],
                'address' => 'required|min:10',
                'lga_id' => 'required|integer|not_in:0',
                'house_id' => 'nullable|integer|not_in:0',
                'religion' => ['nullable','regex:/(Christian|Muslim|Traditional)/'],
                'parent_email' => 'nullable|email',
                'parent_phone' => 'nullable|regex:(234?)|digits:13',
                'phone' => 'nullable|regex:(234?)|digits:13',
                'blood_group' => ['required','regex:/(A+|A-|B+|B-|AB+|AB-|O+|O-)/'],
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

            $details = [
                'surname' => $request->input('surname'),
                'firstname' => $request->input('firstname'),
                'middlename' => $request->input('middlename'),
                'dob' => $request->input('dob'),
                'gender' => $request->input('gender'),
                'address' => $request->input('address'),
                'state_id' => env('STATE_ID'),
                'lga_id' => $request->input('lga_id'),
                'house_id' => $request->input('house_id'),
                'religion' => $request->input('religion'),
                'parent_fullname' => $request->input('parent_fullname'),
                'parent_address' => $request->input('parent_address'),
                'parent_email' => $request->input('parent_email'),
                'parent_phone' => $request->input('parent_phone'),
                'phone' => $request->input('phone'),
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
            
            $student = $setStudent->update($details);

            return response()->json([
                'data' => [
                    'message' => 'Student updated successfully'
                ]
            ]);
        }

    }

    public function updateFloating(Request $request, $id = null)
    {
        $setStudent = $this->student->find($id);

        if($setStudent) {
    
            $messages = [
                'class_id.required' => 'The Class field is required.',
                'classarm_id.required' => 'The Class Arm field is required.',
            ];
    
            $rules = [
                'class_id' => 'required|integer',
                'classarm_id' => 'required|integer',
                'session' => 'required|digits:4',
                'term' => ['required','regex:/(First|Second|Third)/'],
            ];
    
            $this->validate($request, $rules, $messages);

            $class_id = $request->input('class_id');
            $classarm_id = $request->input('classarm_id');
            $session = $request->input('session');
            $term = $request->input('term');

            //Get the school admin id
            $admin_id = Auth::guard('school_api')->id();
            //Get the school_id
            $school_id = $this->admin->find($admin_id)->school_id;

            DB::table('classarm_student')
            ->updateOrInsert(
                ['student_id' => $id],
                [
                    'classarm_id' => $request->input('classarm_id'),
                    'session' => $request->input('session'),
                    'term' => $request->input('term'),
                    'class_id' => $request->input('class_id')
                ]
            );
    
            return response()->json([
                'data' => [
                    'message' => 'The Student has been successfully moved to a Class'
                ]
            ]);
        }

    }

    protected function permissionDeny($ability){
        Auth::shouldUse('school_api');
        return Gate::denies($ability);
    }
}