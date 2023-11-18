<?php

namespace App\Http\Controllers\Admins\ClassArm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\TeacherRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AssignTeacherSubjectController extends Controller
{
    //
    protected $classarm;

    public function __construct(TeacherRepositoryInterface $teacher)
    {

        $this->middleware('auth:school_api');

        $this->teacher = $teacher;
    }

    public function index(Request $request)
    {
        if($this->permissionDeny('assign-subject-to-teacher')){
            return response()->json([
                'message' => 'Permission Denied'
               ],403);
        }

        $request->validate([
            'teacher_id' => 'required|numeric',
            'subjects' => 'required|array'
        ]);

        $school_id = Auth::guard('school_api')->user()->school_id;

        $subjects = $request->input('subjects');

        $setTeacher = $this->teacher->find($request->input('teacher_id'));

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
                'message' => 'Subjects assigned to teacher successfully'
            ]
        ]);

    }

    protected function permissionDeny($ability){
        Auth::shouldUse('school_api');
        return Gate::denies($ability);
    }
}