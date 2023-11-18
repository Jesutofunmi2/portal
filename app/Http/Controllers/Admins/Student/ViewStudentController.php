<?php

namespace App\Http\Controllers\Admins\Student;

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
    protected $admin;

    protected $student;

    public function __construct(AdminRepositoryInterface $admin, StudentRepositoryInterface $student)
    {

        $this->middleware('auth:school_api');

        $this->admin = $admin;

        $this->student = $student;

    }

    public function index(Request $request)
    {
        
        if($this->permissionDeny('view-student')){
           return response()->json([
            'message' => 'Permission Denied'
           ],403);
        }

        $this->validate($request, [
            'class'        => 'nullable|int',
            'arm'          => 'nullable|int',
            'session'      => 'nullable|int',
            'term' => ["nullable", "in:First,Second,Third"]
        ]);
        
        //Get the school admin id
        $admin_id = Auth::guard('school_api')->id();
        //Get the school_id
        $school_id = $this->admin->find($admin_id)->school_id;

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
        ->join('classarm_student', 'students.id', '=', 'classarm_student.student_id')
        ->join('class_arms', 'class_arms.id', '=', 'classarm_student.classarm_id')
        ->join('classes', 'class_arms.class_id', '=', 'classes.id')
        
        ->when($request->query('class'), function ($q, $class_id) { 
            return $q->where('classarm_student.class_id', $class_id);
        })
        ->when($request->query('arm'), function ($q, $arm) { 
            return $q->where('classarm_student.classarm_id', $arm);
        })
        ->when($request->query('session'), function ($q, $session) { 
            return $q->where('classarm_student.session', $session);
        })
        ->when($request->query('term'), function ($q, $term) { 
            return $q->where('classarm_student.term', $term);
        })
        ->orderBy('students.surname','asc')
        ->orderBy('students.firstname','asc')
        ->orderBy('students.middlename','asc')
        ->groupBy('students.surname', 'students.firstname', 'students.middlename')
        ->paginate(80)
        ->appends($request->query());

        return new StudentCollection($query);

    }

    public function getNorminalRoll(Request $request)
    {
        if($this->permissionDeny('view-student')){
           return response()->json([
            'message' => 'Permission Denied'
           ],403);
        }

        $this->validate($request, [
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
        
        //Get the school admin id
        $admin = Auth::guard('school_api')->user();
        //Get the school_id
        $school_id = $admin->school_id;

        $url = GeneralHelper::nominalRoll($school_id, $session, $class_id, $classarm_id, $term, $passport);

        return response()->json([
            'url' => $url
        ]);
    }

    public function getFloating(Request $request)
    {
        
        if($this->permissionDeny('view-student')){
           return response()->json([
            'message' => 'Permission Denied'
           ],403);
        }
        
        //Get the school admin id
        $admin_id = Auth::guard('school_api')->id();
        //Get the school_id
        $school_id = $this->admin->find($admin_id)->school_id;

        //Fully Registered students
        $studIds = DB::table('classarm_student')
        ->join('class_arms', 'classarm_student.classarm_id', '=', 'class_arms.id')
        ->join('classes', 'classarm_student.class_id', '=', 'classes.id')
        ->where('class_arms.school_id', $school_id)
        ->where('classes.school_id', $school_id)
        ->pluck('classarm_student.student_id');

        //Floating students
        $query = $this->student->setStudent()->query()
        ->select('id', 'surname', 'firstname', 'middlename', 'regnum', 'passport')
        ->when($request->query('query'), function ($q, $query) { 
            return $q->where(function ($q) use ($query) { 
                $q->where('surname', 'like', '%'.$query.'%')
                ->orWhere('firstname', 'like', '%'.$query.'%')
                ->orWhere('middlename', 'like', '%'.$query.'%');
            });
        })
        ->where('school_id', $school_id)
        ->whereNotIn('id', $studIds)
        ->orderBy('surname','asc')
        ->orderBy('firstname','asc')
        ->orderBy('middlename','asc')
        ->paginate(20)
        ->appends($request->query());

        return new StudentCollection($query);

    }

    public function getAll() {
        if($this->permissionDeny('view-student')) {
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
        }

        //Get the school admin id
        $admin_id = Auth::guard('school_api')->id();
        //Get the school_id
        $school_id = $this->admin->find($admin_id)->school_id;

        $query = $this->student->setStudent()->query()
        ->select(DB::raw('MAX(id) as id'), 'surname', 'firstname', 'middlename')
        ->where('school_id', $school_id)
        ->orderBy('surname','asc')
        ->orderBy('firstname','asc')
        ->orderBy('middlename','asc')
        ->groupBy('surname', 'firstname', 'middlename')
        ->get();

        return new StudentCollection($query);
    }

    public function getClassStudents(Request $request)
    {
        
        if($this->permissionDeny('view-student')){
           return response()->json([
            'message' => 'Permission Denied'
           ],403);
        }

        $rules = [
            'session' => 'required|integer',
            'term' => ['required','regex:/(First|Second|Third)/'],
            'class_id' => 'required|integer',
            'classarm_id' => 'required|integer',
        ];

        $messages = [
            'class_id.required' => 'Please select a Class',
            'classarm_id.required' => 'Please select a Class Arm',
        ];

        $request->validate($rules, $messages);

        $session = $request->input('session');
        $term = $request->input('term');
        $class_id = $request->input('class_id');
        $classarm_id = $request->input('classarm_id');
        
        //Get the school admin id
        $admin_id = Auth::guard('school_api')->id();
        //Get the school_id
        $school_id = $this->admin->find($admin_id)->school_id;

        $studentIDs = DB::table('classarm_student')
        ->where('classarm_id', $classarm_id)
        ->where('class_id', $class_id)
        ->where('session', $session)
        ->pluck('student_id');

        $query = $this->student->setStudent()->query()
        ->select(DB::raw('MAX(id) as id, MAX(regnum) as regnum, MAX(passport) as passport'), 'surname', 'firstname', 'middlename')
        ->whereIn('id', $studentIDs)
        ->where('school_id', $school_id)
        ->orderBy('surname','asc')
        ->orderBy('firstname','asc')
        ->orderBy('middlename','asc')
        ->groupBy('surname', 'firstname', 'middlename')
        ->get();

        return new StudentCollection($query);

    }
    
    protected function permissionDeny($ability){
        Auth::shouldUse('school_api');
        return Gate::denies($ability);
    }
}