<?php

namespace App\Http\Controllers\Admins\Transfer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use App\Repositories\Interfaces\TeacherRepositoryInterface;
use App\Http\Resources\TeacherCollection;
use Illuminate\Support\Facades\DB;
use Auth;
use Gate;

class ViewInTeacherTransferController extends Controller
{
    //
    protected $admin;

    public function __construct(AdminRepositoryInterface $admin, TeacherRepositoryInterface $teach) 
    {

        $this->middleware('auth:school_api');

        $this->admin = $admin;

        $this->teach = $teach;

    }

    public function index(Request $request)
    {
        if($this->permissionDeny('inward-teacher-transfer-history')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
         }

        //Get the school admin id
        $admin_id = Auth::guard('school_api')->id();
        //Get the school_id
        $school_id = $this->admin->find($admin_id)->school_id;

        $query = $this->teach->setTeacher()->query()
        ->select('transfers_teacher.id as id', 'transfers_teacher.teacher_id as teacher_id', 'transfers_teacher.former_staff_no as former_staff_no', 'transfers_teacher.new_staff_no as new_staff_no', 'schools.name as former_school', 'sch.name as new_school', 'teachers.surname as surname', 'teachers.firstname as firstname', 'teachers.middlename as middlename', 'transfers_teacher.transfer_status as status', 'transfers_teacher.session as session', 'transfers_teacher.term as term', 'transfers_teacher.reason_for_transfer as reason')
        ->join('transfers_teacher', 'teachers.id', '=', 'transfers_teacher.teacher_id')
        ->join('schools', 'transfers_teacher.former_school', '=', 'schools.id')
        ->join('schools as sch', 'transfers_teacher.new_school', '=', 'sch.id')
        ->where('transfers_teacher.new_school', $school_id)
        ->when($request->query('query'), function ($q, $query) { 
            return $q->where(function ($q) use ($query) { 
                $q->where('schools.name', 'like', '%'.$query.'%')
                ->orWhere('teachers.surname', 'like', '%'.$query.'%')
                ->orWhere('teachers.firstname', 'like', '%'.$query.'%')
                ->orWhere('teachers.middlename', 'like', '%'.$query.'%')
                ->orWhere('transfers_teacher.former_staff_no', 'like', '%'.$query.'%')
                ->orWhere('transfers_teacher.new_staff_no', 'like', '%'.$query.'%');
            });
        })
        ->orderBy('transfers_teacher.created_at','desc')
        ->paginate(20)
        ->appends($request->query());

        return new TeacherCollection($query);
    }

    protected function permissionDeny($ability){
        Auth::shouldUse('school_api');
        return Gate::denies($ability);
    }
}