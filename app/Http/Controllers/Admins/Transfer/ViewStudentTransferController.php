<?php

namespace App\Http\Controllers\Admins\Transfer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use App\Http\Resources\StudentResource;
use App\Http\Resources\StudentCollection;
use Auth;
use Gate;

class ViewStudentTransferController extends Controller
{
    //
    protected $admin;

    public function __construct(AdminRepositoryInterface $admin, StudentRepositoryInterface $student) 
    {

        $this->middleware('auth:school_api');

        $this->admin = $admin;

        $this->student = $student;

    }

    public function index(Request $request)
    {
        if($this->permissionDeny('view-transfer')){
            return response()->json([
             'message' => 'Permission Denied'
            ], 403);
         }

        //Get the school admin id
        $admin_id = Auth::guard('school_api')->id();
        //Get the school_id
        $school_id = $this->admin->find($admin_id)->school_id;

        $query = $this->student->setStudent()
        ->select('transfers.id as id', 'transfers.student_former_id', 'transfers.student_former_school as former_school', 'transfers.student_new_school as new_school', 'schools.name as school', 'sch.name as school2', 'students.surname as surname', 'students.firstname as firstname', 'students.middlename as middlename', 'students.regnum as regnum', 'transfers.transfer_status as status', 'transfers.session as session', 'transfers.term as term', 'transfers.reason_for_transfer as reason', 'transfers.debtor_id as debtor_id')
        ->leftJoin('students', 'transfers.student_former_id', '=', 'students.id')
        ->leftJoin('schools', 'transfers.student_former_school', '=', 'schools.id')
        ->leftJoin('schools as sch', 'transfers.student_new_school', '=', 'sch.id')
        ->where(function ($query) {
            $query->where('transfers.student_new_school', $school_id)
                  ->orWhere('transfers.student_former_school', $school_id);
        })
        ->when($request->query('query'), function ($q, $query) { 
            return $q->where(function ($q) use ($query) {
                $q->where('schools.name', 'like', '%'.$query.'%')
                ->orWhere('sch.name', 'like', '%'.$query.'%')
                ->orWhere('students.surname', 'like', '%'.$query.'%')
                ->orWhere('students.firstname', 'like', '%'.$query.'%')
                ->orWhere('students.middlename', 'like', '%'.$query.'%');
            });
        })
        ->orderBy('created_at','desc')
        ->paginate(20)
        ->appends($request->query());

        return new StudentCollection($query);
    }

    protected function permissionDeny($ability){
        Auth::shouldUse('school_api');
        return Gate::denies($ability);
    }
}