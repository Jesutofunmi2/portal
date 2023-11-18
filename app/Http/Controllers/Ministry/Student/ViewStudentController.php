<?php

namespace App\Http\Controllers\Ministry\Student;

use App\Http\Controllers\Controller;
use App\Http\Helper\GeneralHelper;
use App\Http\Resources\MinistryStudentResource;
use App\Models\Student\Student;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ViewStudentController extends Controller 
{
    protected $students;

    public function __construct(StudentRepositoryInterface $student) 
    {
        $this->students = $student;

        $this->middleware('auth:ministry_api');
    }
    public function index(Request $request)
    {
        if($this->permissionDeny('view-student')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
         }

        $student = $this->students->setStudent();

        $this->validate($request, [
            'school_id' => 'required',
            'class_id' => 'required',
            'session' => 'required',
            'class_arm_id' => 'required',
            'term' => 'required'
        ]);

        $session = $request->session;
        $term = $request->term;
        $classarm = $request->class_arm_id;
        $class_id = $request->class_id;
        $school_id = $request->school_id;

        $students = $student
        ->select('students.id', 'students.surname',
                'students.firstname','students.middlename',
                'students.regnum', 'students.passport',
                'students.school_id', 'students.gender')
        ->join('classarm_student', 'students.id' , '=','classarm_student.student_id')
        ->where(['classarm_student.session' => $session,
                'classarm_student.class_id' => $class_id,
                'classarm_student.term' => $term,
                'classarm_student.classarm_id' => $classarm,
                'students.school_id' => $school_id
        ])
        ->orderBy('students.surname','asc')
        ->orderBy('students.firstname','asc')
        ->orderBy('students.middlename','asc')
        ->paginate(60);

        return MinistryStudentResource::collection($students);
    }

    public function getNorminalRoll(Request $request)
    {
        if($this->permissionDeny('view-student')){
           return response()->json([
            'message' => 'Permission Denied'
           ],403);
        }

        $this->validate($request, [
            'school_id' => 'required|int',
            'class' => 'required|int',
            'arm' => 'required|int',
            'session' => 'required|int',
            'term'  => ["required", "in:First,Second,Third"]
        ]);

        $session = $request->session;
        $term = $request->term;
        $classarm_id = $request->arm;
        $class_id = $request->class;
        $passport = $request->has('passport');
        $school_id = $request->school_id;

        $url = GeneralHelper::nominalRoll($school_id, $session, $class_id, $classarm_id, $term, $passport);

        return response()->json([
            'url' => $url
        ]);
    }

    protected function permissionDeny($ability){
        Auth::shouldUse('ministry_api');
        return Gate::denies($ability);
    }
}