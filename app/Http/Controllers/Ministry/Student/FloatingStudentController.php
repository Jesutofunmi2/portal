<?php

namespace App\Http\Controllers\Ministry\Student;

use Auth;
use Gate;
use Illuminate\Http\Request;
use App\Models\Student\Student;
use App\Http\Controllers\Controller;
use App\Http\Resources\MinistryStudentResource;
use App\Repositories\Interfaces\ClassRepositoryInterface;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use App\Repositories\Interfaces\ClassArmRepositoryInterface;

class FloatingStudentController extends Controller 
{
    protected $students;
    protected $classes;
    protected $class_arms;

    public function __construct(
        StudentRepositoryInterface $student,
        ClassRepositoryInterface $classes,
        ClassArmRepositoryInterface $class_arm 
        )
    {
        $this->students = $student;
        $this->classes = $classes;
        $this->class_arms = $class_arm;

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
            'school_id' => 'required'
        ]);
       
        $school_id = $request->school_id;
        
        $students = $student
        ->select('students.id', 'students.surname', 
                'students.firstname','students.middlename',
                'students.regnum', 'students.school_id',
                )
        ->leftJoin('classarm_student', 'students.id' , '=','classarm_student.student_id')
        ->where([
            'students.school_id' => $school_id,
            'classarm_student.student_id' => null
            ])
        ->paginate(40);

        return MinistryStudentResource::collection($students);
    }

    public function view(Request $request)
    {
        if($this->permissionDeny('view-student')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
        }

        $this->validate($request, [
            'student_id' => 'required|integer'
        ]);
        $student = $this->students->find($request->student_id);

        $student_class =  $student->classarms()->wherePivot('session', '=',$student->session)
                ->orderBy('term', 'desc')
                ->first();

        $class = $this->classes->find($student_class->class_id)->first();

        return response()->json([
            'data' => [
                'id' => $student->id,
                'name' => "$student->surname $student->firstname $student->middlename",
                'ossi' => $student->regnum,
                'gender' => $student->gender ?? 'Unknown',
                'class' => "$class->class_name ($student_class->class_arm)",
            ]
        ]);
    }

    public function update(Request $request)
    {
        if($this->permissionDeny('assign-student-to-classarm')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
        }

        $this->validate($request, [
            'ids' => ['required', 'array'],
            'class_id' => ['required', 'integer'],
            'class_arm_id' => ['required', 'integer'],
            'session' => ['required', 'integer'],
            'term' => ['required', 'regex:/(First|Second|Third)/']
        ]);
                
        $classarms = $this->class_arms->find($request->class_arm_id);

        $classarms->students()->attach($request->ids, ['session' => $request->input('session'), 'term' => $request->input('term'), 'class_id' => $request->input('class_id')]);
        
        $student = $this->students->setStudent()->whereIn('id', $request->ids)->update(['session' => $request->input('session')]);

        return response()->json([
            'data' => [
                'message' => 'Updated Successfully'
            ]
        ]);
    }

    protected function permissionDeny($ability){
        Auth::shouldUse('ministry_api');
        return Gate::denies($ability);
    }
}