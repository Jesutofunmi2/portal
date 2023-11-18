<?php

namespace App\Http\Controllers\Admins\Transfer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use App\Repositories\Interfaces\TeacherRepositoryInterface;
use App\Http\Resources\TeacherResource;
use App\Http\Resources\TeacherCollection;
use Auth;
use Gate;

class NewTeacherTransferController extends Controller
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
        
        if($this->permissionDeny('new-teacher-transfer')){
           return response()->json([
            'message' => 'Permission Denied'
           ],403);
        }

        //Get the school admin id
        $admin_id = Auth::guard('school_api')->id();
        //Get the school_id
        $school_id = $this->admin->find($admin_id)->school_id;
        
        $query = $this->teacher->setTeacher()->query()
        ->select('id', 'surname', 'firstname', 'middlename', 'staff_no')
        ->with(['subjects' => function ($query) {
            $query->orderBy('subject_name', 'asc');
        }])
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
        ->paginate(20)
        ->appends($request->query());

        return new TeacherCollection($query);

    }

    protected function permissionDeny($ability){
        Auth::shouldUse('school_api');
        return Gate::denies($ability);
    }
}