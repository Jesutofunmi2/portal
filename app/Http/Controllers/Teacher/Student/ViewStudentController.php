<?php

namespace App\Http\Controllers\Teacher\Student;

use App\Http\Controllers\Controller;
use App\Http\Helper\GeneralHelper;
use App\Http\Resources\StudentCollection;
use App\Http\Resources\StudentResource;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ViewStudentController extends Controller
{
    //
    protected $student;

    public function __construct(StudentRepositoryInterface $student)
    {
        $this->middleware('auth:teacher_api');

        $this->student = $student;
    }

    public function index(Request $request)
    {
        $this->validate($request, [
            'classarm_id'          => 'required|int',
            'session'      => 'required|int',
            'term' => ["required", "in:First,Second,Third"]
        ]);

        //Get the teacher id
        $teacher = Auth::guard('teacher_api')->user();
        $teacher_id = $teacher->id;
        $school_id = $teacher->school_id;
        $classarm_id = $request->classarm_id;

        if(! $this->permissionDeny($teacher_id, $classarm_id)){
            return response()->json([
             'message' => 'Sorry, you do not have access to this class arm'
            ],403);
        }

        $query = $this->student->setStudent()->query()
        ->select(DB::raw('MAX(students.id) as id, MAX(students.regnum) as regnum, MAX(students.passport) as passport, MAX(classes.class_name) as clas, MAX(class_arms.class_arm) as arm, MAX(classarm_student.session) as session, MAX(classarm_student.term) as term'), 'students.surname as surname', 'students.firstname as firstname', 'students.middlename as middlename')
        ->when($request->query('query'), function ($q, $query) { 
            return $q->where(function ($q) use ($query) { 
                $q->where('students.surname', 'like', '%'.$query.'%')
                ->orWhere('students.firstname', 'like', '%'.$query.'%')
                ->orWhere('students.middlename', 'like', '%'.$query.'%');
            });
        })
        ->where('students.school_id', $school_id)
        ->where('classarm_student.classarm_id', $classarm_id)
        ->where('classarm_student.session', $request->session)
        ->when($request->query('term'), function ($q, $term) { 
            return $q->where('classarm_student.term', $term);
        })
        ->join('classarm_student', 'students.id', '=', 'classarm_student.student_id')
        ->join('class_arms', 'class_arms.id', '=', 'classarm_student.classarm_id')
        ->join('classes', 'class_arms.class_id', '=', 'classes.id')
        ->orderBy('students.surname','asc')
        ->orderBy('students.firstname','asc')
        ->orderBy('students.middlename','asc')
        ->groupBy('students.surname', 'students.firstname', 'students.middlename')
        ->paginate(80)
        ->appends($request->query());

        return new StudentCollection($query);
    }

    public function classarms(Request $request)
    {
        
        $this->validate($request, [
            'session'      => 'required|int'
        ]);
       
        //Get the teacher id
        $teacher = Auth::guard('teacher_api')->user();
        $teacher_id = $teacher->id;

        $classarms = DB::table('classarm_teacher')
                        ->select('class_arms.id as classarm_id', 'class_arms.class_arm as classarm_name','classes.id as class_id', 'classes.class_name as class_name')
                        ->where('teacher_id', $teacher_id)
                        ->where('session', $request->session)
                        ->join('class_arms', 'class_arms.id', '=', 'classarm_teacher.classarm_id')
                        ->join('classes', 'classes.id' , '=', 'class_arms.class_id')
                        ->get();

        return response()->json([
            'data' => $classarms
        ]);
    }

    protected function permissionDeny($teacher_id, $classarm_id) {
        $classarm_subject = DB::table('classarm_subject')
        ->where('teacher_id', $teacher_id)
        ->where('classarm_id', $classarm_id)
        ->exists();

        if($classarm_subject) return true;

        $classarm_teacher = DB::table('classarm_teacher')
        ->where('teacher_id', $teacher_id)
        ->where('classarm_id', $classarm_id)
        ->exists();

        if($classarm_teacher) return true;

        return false;
    }
}