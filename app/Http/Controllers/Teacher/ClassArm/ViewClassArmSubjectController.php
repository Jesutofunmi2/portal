<?php

namespace App\Http\Controllers\Teacher\ClassArm;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\TeacherRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ViewClassArmSubjectController extends Controller
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
    * Retrieve all Class Arms Assigned Subject for Teacher
    *
    * @param Int $classarm_id
    * @param Int $session
    * @return Json 
     */
     public function index(Request $request) {

        $this->validate($request, [
            'classarm_id'  => 'required|int',
            'session'      => 'required|int'
        ]);

        $teacher        = Auth::guard('teacher_api')->user();
        $teacher_id     = $teacher->id;
        $classarm_id    = $request->classarm_id;
        $session        = $request->session;

        if(! $this->permissionDeny($teacher_id, $classarm_id)){
            return response()->json([
             'message' => 'Sorry, you do not have access to this class arm'
            ],403);
        }
        
        $teachSubjects = DB::table('classarm_subject')
                            ->select('classarm_subject.subject_id', 'subjects.subject_name')
                            ->join('subjects', 'subjects.id', '=', 'classarm_subject.subject_id')
                            ->where('classarm_subject.teacher_id', $teacher_id)
                            ->where('classarm_subject.classarm_id', $classarm_id)
                            ->get();

        return response()->json([
            'data' => $teachSubjects,
        ]);
    }


    public function classArmSubject(Request $request) {

        $teacher        = Auth::guard('teacher_api')->user();
        $teacher_id     = $teacher->id;
        
        $data = DB::table('classarm_subject')
                            ->select('classarm_subject.subject_id', 'classarm_subject.classarm_id', 'subjects.subject_name',
                                    'class_arms.class_id', 'class_arms.class_arm', 'classes.class_name'
                            )
                            ->join('subjects', 'subjects.id', '=', 'classarm_subject.subject_id')
                            ->join('class_arms', 'class_arms.id', '=', 'classarm_subject.classarm_id')
                            ->join('classes', 'classes.id', '=', 'class_arms.class_id')
                            ->where('classarm_subject.teacher_id', $teacher_id)
                            ->get();

        return response()->json([
            'data' => $data
        ]);
    }


    protected function permissionDeny($teacher_id, $classarm_id) {
        return DB::table('classarm_teacher')
                    ->where('teacher_id', $teacher_id)
                    ->where('classarm_id', $classarm_id)
                    ->exists();
    }
}