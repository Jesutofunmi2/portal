<?php

namespace App\Http\Controllers\Admins\SchoolID;

use Auth;
use Gate;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClassResource;
use App\Http\Resources\StudentCollection;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use App\Repositories\Interfaces\ClassRepositoryInterface;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use App\Models\StudentIDCardRequest;

class ViewStudentController extends Controller
{
    //
    protected $admin;

    protected $student;

    /**
    * Class Repository class
    * @var obj
    */
    protected $clas;

    public function __construct(AdminRepositoryInterface $admin,
                            StudentRepositoryInterface $student,
                            ClassRepositoryInterface $clas)
    {

        $this->middleware('auth:school_api');

        $this->admin = $admin;
        $this->student = $student;
        $this->clas = $clas;

    }

    public function index(Request $request)
    {  
        if($this->permissionDeny('view-student')){
           return response()->json([
            'message' => 'Permission Denied'
           ],403);
        }

        $this->validate($request, [
            'class'        => 'required|int',
            'arm'          => 'sometimes|int',
            'session'      => 'required|int'
        ]);
        
        //Get the school admin id
        $admin_id = Auth::guard('school_api')->id();
        //Get the school_id
        $school_id = $this->admin->find($admin_id)->school_id;

        $query = $this->student->setStudent()->query()
        ->select('students.id as id', 'students.surname as surname', 'students.firstname as firstname', 'students.middlename as middlename', 'students.regnum as regnum', 'students.passport as passport')
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
        ->distinct('students.id')
        ->orderBy('students.surname','asc')
        ->orderBy('students.firstname','asc')
        ->orderBy('students.middlename','asc')
        ->paginate(40);

        return new StudentCollection($query);

    }

    public function view(Request $request)
    {
        $request->validate(['session' => ['sometimes', 'integer']]);
        //Get the school admin id
        $admin_id = Auth::guard('school_api')->id();
        //Get the school_id
        $school_id = $this->admin->find($admin_id)->school_id;

        $school = School::find($school_id);
        if($school->logo == '/images/school_logos/Nigerian-Coat-of-Arm-icon.png' ||
            $school->logo == '' || $school->logo == null)
        {
		    abort(400, 'Please upload school logo to access this feature');
		}

        $schoolRequest = new StudentIDCardRequest;
        $all= $schoolRequest::where('school_id', $school_id)
        ->when($request->session, function($query, $session) {
            return $query->whereSession($session);
        })
        ->count();
        $approved = $schoolRequest::where('school_id', $school_id)->where('is_verified', true)
        ->when($request->session, function($query, $session) {
            return $query->whereSession($session);
        })
        ->count();
        $pending = $schoolRequest::where('school_id', $school_id)->where('is_verified', false)
        ->when($request->session, function($query, $session) {
            return $query->whereSession($session);
        })
        ->count();

        $query = $this->clas->setClass()->query();

        $classes = $query
        ->where('school_id', $school_id)
        ->when($request->query('query'), function ($q, $query) {
            return $q->where('class_name', 'like', '%'.$query.'%');
        })
        ->orderBy('class_name', 'asc')
        ->paginate(40);

        return ClassResource::collection($classes)->additional([
           'id_request_statistics' => [
                                    'all' => $all,
                                    'pending' => $pending,
                                    'approved' => $approved
                                    ]
        ]);
    }
    
    protected function permissionDeny($ability){
        Auth::shouldUse('school_api');
        return Gate::denies($ability);
    }
}