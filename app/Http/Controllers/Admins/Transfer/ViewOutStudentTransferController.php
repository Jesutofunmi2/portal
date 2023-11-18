<?php

namespace App\Http\Controllers\Admins\Transfer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use App\Http\Resources\TransferResource;
use Illuminate\Support\Facades\DB;
use Auth;
use Gate;

class ViewOutStudentTransferController extends Controller
{
    //
    protected $admin;

    public function __construct(AdminRepositoryInterface $admin) 
    {

        $this->middleware('auth:school_api');

        $this->admin = $admin;

    }

    public function index(Request $request)
    {
        
        //Get the school admin id
        $admin_id = Auth::guard('school_api')->id();
        //Get the school_id
        $school_id = $this->admin->find($admin_id)->school_id;

        $query = DB::table('transfers_teacher')
        ->select('transfers_teacher.id as id', 'transfers_teacher.teacher_id as teacher_id', 'transfers_teacher.former_staff_no as former_staff_no', 'transfers_teacher.new_staff_no as new_staff_no', 'schools.name as school', 'teachers.surname as surname', 'teachers.firstname as firstname', 'teachers.middlename as middlename', 'transfers_teacher.transfer_status as status', 'transfers_teacher.session as session', 'transfers_teacher.term as term', 'transfers_teacher.reason_for_transfer as reason')
        ->leftJoin('teachers', 'transfers_teacher.teacher_id', '=', 'teachers.id')
        ->leftJoin('schools', 'transfers_teacher.former_school', '=', 'schools.id')
        ->where('transfers_teacher.former_school', $school_id)
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
        ->orderBy('created_at','desc')
        ->paginate(20)
        ->appends($request->query());

        return TransferTeacherResource::collection($query);

    }

    protected function permissionDeny($ability){
        Auth::shouldUse('school_api');
        return Gate::denies($ability);
    }
}