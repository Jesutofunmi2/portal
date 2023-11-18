<?php

namespace App\Http\Controllers\Admins\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\StudentCollection;
use App\Http\Resources\StudentResource;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ViewStudentSubjectController extends Controller
{
    /**
    * Student Repository class
    * @var obj
    */
    protected $student;

    /**
    * Admin Repository class
    * @var obj
    */
    protected $admin;

    /**
    * Initialise Controller
    */
    public function __construct(AdminRepositoryInterface $admin, StudentRepositoryInterface $student) {
        $this->middleware('auth:school_api');

        $this->admin = $admin;
        $this->student = $student;
    }

    /**
    * Fetch All Student Subjects in a given School
    *
    * @param Request $request
    * @return Resource
    */
    public function index(Request $request)
    {
        /*
        if($this->permissionDeny('assign-subject-to-student')){
            return response()->json([
                'message' => 'Permission Denied'
               ],403);
        }
        */

        //Get the school admin id
        $admin_id = Auth::guard('school_api')->id();
        //Get the school_id
        $school_id = $this->admin->find($admin_id)->school_id;

        $query = $this->student->setStudent()->query();

        $students = $query
        ->select(DB::raw('MAX(id) as id'), 'surname', 'firstname', 'middlename')
        ->where('school_id', $school_id)
        ->when($request->query('query'), function ($q, $query) {
            return $q->where('surname', 'like', '%'.$query.'%')
            ->orWhere('firstname', 'like', '%'.$query.'%')
            ->orWhere('middlename', 'like', '%'.$query.'%');
        })
        ->with(['classarms.subjects' => function ($query) {
            $query->orderBy('subject_name', 'asc');
            }, 'subjectsUnoffered']
        )
        ->orderBy('surname', 'asc')
        ->orderBy('firstname', 'asc')
        ->orderBy('middlename', 'asc')
        ->groupBy('surname', 'firstname', 'middlename')
        ->paginate(15)
        ->appends($request->query());
        
        return new StudentCollection($students);

    }

    protected function permissionDeny($ability){
        Auth::shouldUse('school_api');
        return Gate::denies($ability);
    }
}