<?php

namespace App\Http\Controllers\Ministry\Transfer;

use App\Http\Controllers\Controller;
use App\Http\Resources\TeacherCollection;
use App\Models\TransferTeacher;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use App\Repositories\Interfaces\TeacherRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ViewInOutTeacherTransferController extends Controller
{
    //
    protected $admin;

    public function __construct(TeacherRepositoryInterface $teach) 
    {

        $this->middleware('auth:ministry_api');

        $this->teach = $teach;
    }

    public function index(Request $request)
    {
        if($this->permissionDeny('inward-teacher-transfer-history')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
         }

        $query = $this->teach->setTeacher()->query()->count();

        $query = TransferTeacher::query()
        ->select('transfers_teacher.id as id', 'transfers_teacher.teacher_id as teacher_id',
                'transfers_teacher.former_staff_no as former_staff_no', 'transfers_teacher.new_staff_no as new_staff_no',
                'schools_new.name as former_school', 'sch.name as new_school', 'teachers.surname as surname',
                'teachers.firstname as firstname', 'teachers.middlename as middlename', 'transfers_teacher.transfer_status as status',
                'transfers_teacher.session as session', 'transfers_teacher.term as term',
                'transfers_teacher.reason_for_transfer as reason')
        ->join('teachers', 'teachers.id', '=', 'transfers_teacher.teacher_id')
        ->join('schools_new', 'transfers_teacher.former_school', '=', 'schools_new.id')
        ->join('schools_new as sch', 'transfers_teacher.new_school', '=', 'sch.id')
        ->where('teachers.deleted_at', null)
        ->when($request->has('transfer_status'), function ($q, $transfer_status) use ($request) {
            $q->where('transfers_teacher.transfer_status', $request->query('transfer_status'));
        })
        ->when($request->query('school_id'), function ($q, $school_id) {
            $q->where('transfers_teacher.new_school', $school_id)
            ->orWhere('transfers_teacher.former_school', $school_id);
        })
        ->when($request->query('query'), function ($q, $query) { 
            return $q->where(function ($q) use ($query) { 
                $q->where('schools_new.name', 'like', '%'.$query.'%')
                ->orWhere('teachers.surname', 'like', '%'.$query.'%')
                ->orWhere('teachers.firstname', 'like', '%'.$query.'%')
                ->orWhere('teachers.middlename', 'like', '%'.$query.'%')
                ->orWhere('transfers_teacher.former_staff_no', 'like', '%'.$query.'%')
                ->orWhere('transfers_teacher.new_staff_no', 'like', '%'.$query.'%');
            });
        })
        ->orderBy('transfers_teacher.created_at','desc')
        ->orderBy('transfers_teacher.session','desc')
        ->paginate(50)
        ->appends($request->query());

        return new TeacherCollection($query);
    }

    protected function permissionDeny($ability){
        Auth::shouldUse('ministry_api');
        return Gate::denies($ability);
    }
}