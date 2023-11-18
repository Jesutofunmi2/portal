<?php

namespace App\Http\Controllers\Teacher\ClassArm;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\TeacherRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ViewTeacherClassController extends Controller
{
    /**
    * teacher Repository class
    * @var obj
    */
    protected $teacher;

    /**
    * Initialise Controller
    */
    public function __construct(TeacherRepositoryInterface $teacher) {
        $this->middleware('auth:teacher_api');

        $this->teacher = $teacher;
    }

    /**
    * Retrieve all Class Arms for a Class
    *
    * @param Request $request
    * @param Int $session
    * @return Json 
     */
     public function index() {
        $session = env('CURRENT_SESSION');
        //Get the teacher id
        $teacher_id = Auth::guard('teacher_api')->id();
        //Get the school_id
        $school_id = $this->teacher->find($teacher_id)->school_id;

        $teachClass = DB::table('classarm_teacher')
        ->select('classes.id as class_id', 'class_arms.id as classarm_id', 'classes.class_name as class_name', 'class_arms.class_arm as class_arm')
        ->join('class_arms', 'classarm_teacher.classarm_id', '=', 'class_arms.id')
        ->join('classes', 'class_arms.class_id', '=', 'classes.id')
        ->where('classarm_teacher.teacher_id', $teacher_id)
        ->where('classarm_teacher.session', $session)
        ->get();

        return response()->json([
            'data' => $teachClass,
        ]);
    }

    /**
    * Retrieve Class Arm for a Subject Teacher
    *
    * @param Int $subject_id
    * @param Int $session
    * @return Json $clas
     */
     public function getSubjectClass($subject_id, $session) {
        
        //Get the teacher id
        $teacher_id = Auth::guard('teacher_api')->id();
        //Get the school_id
        $school_id = $this->teacher->find($teacher_id)->school_id;

        $clas = DB::table('classarm_subject')
        ->select('class_arms.id as classarm_id', 'class_arms.class_arm as class_arm', 'classes.id as class_id', 'classes.class_name as class_name')
        ->join('class_arms', 'classarm_subject.classarm_id', '=', 'class_arms.id')
        ->join('classes', 'class_arms.class_id', '=', 'classes.id')
        ->where('classarm_subject.teacher_id', $teacher_id)
        ->where('classarm_subject.subject_id', $subject_id)
        ->where('class_arms.school_id', $school_id)
        ->groupBy('classarm_id')
        ->get();

        return response()->json([
            'data' => $clas,
        ]);
    }

    protected function permissionDeny($ability){
        Auth::shouldUse('teacher_api');
        return Gate::denies($ability);
    }
}