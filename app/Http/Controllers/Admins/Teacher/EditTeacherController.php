<?php

namespace App\Http\Controllers\Admins\Teacher;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\TeacherRepositoryInterface;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use App\Http\Resources\TeacherResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Auth;
use Gate;

class EditTeacherController extends Controller
{
    //
    protected $teacher;

    protected $admin;

    public function __construct(TeacherRepositoryInterface $teacher, AdminRepositoryInterface $admin)
    {

        $this->middleware('auth:school_api');

        $this->teacher = $teacher;

        $this->admin = $admin;

    }


    public function index($id=null)
    {
        
        if($this->permissionDeny('edit-teacher')){
           return response()->json([
            'message' => 'Permission Denied'
           ],403);
        }
        
        $teacher = $this->teacher->setTeacher()
        ->with(['subjects' => function ($query) {
                $query->orderBy('subject_name', 'asc');
            }
        ])
        ->find($id);

        return response()->json([
            'data' => $teacher,
        ]);

    }

    public function update(Request $request,$id=null)
    {
        $setTeacher = $this->teacher->find($id);
        if($setTeacher){

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
                'email' => ['required', 'email', Rule::unique('teachers')->ignore($setTeacher->id)],
                'subjects' => 'required',
                'phone' => 'required|regex:(234?)',
                'lga_id' => 'required|integer',
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
                $path = \Storage::put($file_name, (string) $image );
                // Getting the URL....
                $url =  '/'.$file_name;
                $details['passport'] = $url;
            }
            
            $teacher = $setTeacher->update($details);

            $subjects = json_decode($request->input('subjects'));

            //Remove subjects from teacher
            $setTeacher->subjects()->detach();

            //Attach new subjects to Teacher
            foreach ($subjects as $subj) {
                $setTeacher->subjects()->attach($subj, [
                    'school_id' => $school_id,
                ]);
            }

            return response()->json([
                'data' => [
                    'message' => 'Teacher updated successfully'
                ]
            ]);
        }
    }

    protected function permissionDeny($ability){
        Auth::shouldUse('school_api');
        return Gate::denies($ability);
    }
}
