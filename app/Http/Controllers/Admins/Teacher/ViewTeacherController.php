<?php

namespace App\Http\Controllers\Admins\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Resources\MinistryViewTeacherResource;
use App\Http\Resources\TeacherCollection;
use App\Http\Resources\TeacherResource;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use App\Repositories\Interfaces\TeacherRepositoryInterface;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ViewTeacherController extends Controller
{
    //
    protected $admin;

    protected $teacher;

    public function __construct(AdminRepositoryInterface $admin, TeacherRepositoryInterface $teacher) 
    {

        $this->middleware('auth:school_api');

        $this->admin = $admin;

        $this->teacher = $teacher;

    }


    public function index(Request $request)
    {
        
        if($this->permissionDeny('view-teacher')){
           return response()->json([
            'message' => 'Permission Denied'
           ],403);
        }

        //Get the school admin id
        $admin_id = Auth::guard('school_api')->id();
        //Get the school_id
        $school_id = $this->admin->find($admin_id)->school_id;
        
        $query = $this->teacher->setTeacher()->query()
        ->select(DB::raw('MAX(id) as id, MAX(title) as title, MAX(staff_no) as staff_no, MAX(gender) as gender, MAX(passport) as passport'), 'surname', 'firstname', 'middlename')
        ->where('school_id', $school_id)
        ->when($request->query('query'), function ($q, $query) { 
            return $q->where(function ($q) use ($query) { 
                $q->where('surname', 'like', '%'.$query.'%')
                ->orWhere('firstname', 'like', '%'.$query.'%')
                ->orWhere('middlename', 'like', '%'.$query.'%')
                ->orWhere('staff_no', 'like', '%'.$query.'%');
            });
        })
        ->orderBy('surname','asc')
        ->orderBy('firstname','asc')
        ->orderBy('middlename','asc')
        ->groupBy('surname', 'firstname', 'middlename')
        ->paginate(20)
        ->appends($request->query());

        return new TeacherCollection($query);

    }

    public function getAll() 
    {
        if($this->permissionDeny('view-teacher')) {
            return response()->json([
                'message' => 'Permission Denied'
            ],403);
        }

        //Get the school admin id
        $admin_id = Auth::guard('school_api')->id();
        //Get the school_id
        $school_id = $this->admin->find($admin_id)->school_id;
        
        $query = $this->teacher->setTeacher()->query()
        ->select(DB::raw('MAX(id) as id, MAX(title) as title'), 'surname', 'firstname', 'middlename')
        ->where('school_id', $school_id)
        ->orderBy('surname','asc')
        ->orderBy('firstname','asc')
        ->orderBy('middlename','asc')
        ->groupBy('surname', 'firstname', 'middlename')
        ->get();

        return new TeacherCollection($query);
    }

    public function getAllFormatted()
    {
        if($this->permissionDeny('view-teacher')) {
            return response()->json([
                'message' => 'Permission Denied'
            ],403);
        }

        //Get the school admin id
        $school_id = Auth::guard('school_api')->user()->school_id;

        $teachers = $this->teacher->setTeacher()->where('school_id', $school_id)
            ->orderBy('surname', 'desc')->get();

        return MinistryViewTeacherResource::collection($teachers);
    }

    protected function permissionDeny($ability){
        Auth::shouldUse('school_api');
        return Gate::denies($ability);
    }
}