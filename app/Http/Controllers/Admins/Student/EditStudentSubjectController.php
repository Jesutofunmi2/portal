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
use Illuminate\Validation\Rule;

class EditStudentSubjectController extends Controller
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
        /*
        if($this->permissionDeny('edit-assign-subject-to-student')){
           return response()->json([
            'message' => 'Permission Denied'
           ],403);
        }
        */

        //Get the school admin id
        $admin_id = Auth::guard('school_api')->id();
        //Get the school_id
        $school_id = $this->admin->find($admin_id)->school_id;
        
        $student = $this->student->setStudent()
        ->with(['classarms.subjects' => function ($query) {
                $query->orderBy('subject_name', 'asc');
            }, 'subjectsUnoffered']
        )
        ->find($id);

        return response()->json([
            'data' => $student
        ]);

    }

    public function update(Request $request, $id = null)
    {
        $setStudent = $this->student->find($id);

        if ($setStudent) {

            //Get the school admin id
            $admin_id = Auth::guard('school_api')->id();
            //Get the school_id
            $school_id = $this->admin->find($admin_id)->school_id;
    
            $messages = [
                'subjects.required' => 'Select a Subject.',
            ];
    
            $rules = [
                    'subjects' => 'required',
                    'session'  => 'required|integer',
            ];
        
            $this->validate($request, $rules, $messages);

            $subjects = json_decode($request->input('subjects'));

            $setStudent->subjectsUnoffered()->detach();

            $classarm_id = DB::table('classarm_student')
            ->where('student_id', $id)
            ->value('classarm_id');

            foreach ($subjects as $subj) {
                $setStudent->subjectsUnoffered()->attach($subj, [
                    'classarm_id' => $classarm_id,
                    'session' => $request->input('session'),
                ]);

            }

            return response()->json([
                'data' => [
                    'message' => 'Student Subjects updated successfully'
                ]
            ]);
        }

    }

    protected function permissionDeny($ability){
        Auth::shouldUse('school_api');
        return Gate::denies($ability);
    }
}