<?php

namespace App\Http\Controllers\Teacher\Subject;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\TeacherResource;
use App\Repositories\Interfaces\TeacherRepositoryInterface;
use Auth;
use Gate;

class UpdateSubjectController extends Controller
{
    //
    protected $teach;

    public function __construct(TeacherRepositoryInterface $teacher) {
        $this->middleware('auth:teacher_api');

        $this->teach = $teacher;
    }

    /**
    * Add Teacher Subject
    * 
    * @param Request $request
    * @return Json
    */
    public function index(Request $request) {
        /*
        if($this->permissionDeny('create-classarm')){
            return response()->json([
                'message' => 'Permission Denied'
               ],403);
        }
        */
        
        //Get the teacher id
        $teach_id = Auth::guard('teacher_api')->id();
        //Get Teacher
        $teach = $this->teach->find($teach_id);
        //Get the school_id
        $school_id = $teach->school_id;
        
        $rules = [
                'subjects' => 'required',
        ];

        $this->validate($request, $rules);
        
        $subjects = json_decode($request->input('subjects'));

        //Remove subjects from teacher
        $teach->subjects()->detach();

        //Attach new subjects to Teacher
        foreach ($subjects as $subj) {
            $teach->subjects()->attach($subj, [
                'school_id' => $school_id,
            ]);
        }

        return response()->json([
            'data' => [
                'message' => "Subjects updated successfully"
            ]
        ]);
    }

    /**
    * Check for avility to perform action
    * 
    * @param string $ability
    * @return Gate
    */
    protected function permissionDeny($ability){
        Auth::shouldUse('teacher_api');
        return Gate::denies($ability);
    }
}