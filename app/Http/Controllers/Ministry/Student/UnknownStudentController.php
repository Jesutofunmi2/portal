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

class UnknownStudentController extends Controller 
{
    protected $students;
    protected $classes;

    public function __construct(
        StudentRepositoryInterface $student,
        ClassRepositoryInterface $classes) 
    {
        $this->students = $student;
        $this->classes = $classes;

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
        ->select('id', 'surname', 
                'firstname','middlename',
                'regnum', 'school_id'
                )
        ->where(['school_id' => $school_id])
        ->whereNotIn('gender', ['Male', 'Female'])
        ->distinct('id')
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

        $class = null;

        if ($student_class) $class = $this->classes->setClass()->findOrFail($student_class->class_id)->first();

        return response()->json([
            'data' => [
                'id' => $student->id,
                'name' => "$student->surname $student->firstname $student->middlename",
                'ossi' => $student->regnum,
                'gender' => $student->gender ?? 'Unknown',
                'class' => $class ? "$class->class_name ($student_class->class_arm)" : 'No Class',
            ]
        ]);
    }

    public function update(Request $request)
    {
        if($this->permissionDeny('view-student')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
        }

        $this->validate($request, [
            'student_id' => 'required|integer',
            'gender' => ['required', 'regex:/(Male|Female)/']
        ]);

        $student = $this->students->setStudent()
                ->findOrFail($request->student_id)
                ->update(['gender' => $request->gender]);

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