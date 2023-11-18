<?php

namespace App\Http\Controllers\Teacher\Profile;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Repositories\Interfaces\TeacherRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\ImageManager;

class EditProfileController extends Controller
{
    //
    protected $teacher;

    public function __construct(TeacherRepositoryInterface $teacher)
    {

        $this->middleware('auth:teacher_api');

        $this->teach = $teacher;

    }

    public function index()
    {

        //Get the teacher id
        $teach = Auth::guard('teacher_api')->user();
        
        $school = School::find($teach->school_id);
        
        $teachClass = DB::table('classarm_teacher')
        ->select('classes.id as class_id', 'class_arms.id as classarm_id', 'classes.class_name as class_name', 'class_arms.class_arm as class_arm')
        ->join('class_arms', 'classarm_teacher.classarm_id', '=', 'class_arms.id')
        ->join('classes', 'class_arms.class_id', '=', 'classes.id')
        ->where('classarm_teacher.teacher_id', $teach->id)
        ->get();

        return response()->json([
            'data' => $teach,
            'school_data' => $school,
            'teacher_class' => $teachClass
        ]);

    }

    public function update(Request $request)
    {
        //Get the teacher id
        $teach_id = Auth::guard('teacher_api')->id();

        $setTeacher = $this->teach->find($teach_id);
        if($setTeacher) {

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
                'email' => ['required', 'email', Rule::unique('teachers')->ignore($teach_id)],
                'phone' => 'required|regex:(234?)',
                'lga_id' => 'required|integer',
                'next_of_kins' => 'required|min:10',
                'next_of_kins_address' => 'required|min:10',
                'next_of_kins_phone' => 'required|regex:(234?)',
                'next_of_kins_email' => 'sometimes|email',
                'health_status' => ['required', 'regex:/(Normal|Disable)/'],
                'health_status_desc' => 'required|min:3',
                'passport' => 'nullable|image|mimes:jpeg,jpg,png|min:250'
            ];
    
            $this->validate($request, $rules, $messages);

            //Get the school_id
            $school_id = $setTeacher->school_id;
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
                'email' => $request->input('email'),
                'gender' => $request->input('gender'),
                'title' => $request->input('title'),
                'address' => $request->input('address'),
                'state_id' => $state_id,
                'lga_id' => $request->input('lga_id'),
                'qualification' => $request->input('qualification'),
                'health_status' => $request->input('health_status'),
                'health_status_desc' => $request->input('health_status_desc'),
                'next_of_kins' => $request->input('next_of_kins'),
                'next_of_kins_address' => $request->input('next_of_kins_address'),
                'next_of_kins_email' => $request->input('next_of_kins_email'),
                'next_of_kins_phone' => $request->input('next_of_kins_phone'),
                'phone' => $request->input('phone'),
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
                $path = Storage::put($file_name, (string) $image );
                // Getting the URL....
                $url =  '/'.$file_name;
                $details['passport'] = $url;
            }
            
            $teacher = $setTeacher->update($details);

            return response()->json([
                'data' => [
                    'message' => 'Profile updated successfully'
                ]
            ]);
        }

    }

    protected function permissionDeny($ability) 
    {
        Auth::shouldUse('school_api');
        return Gate::denies($ability);
    }
}