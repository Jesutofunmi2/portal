<?php

namespace App\Http\Controllers\Admins\Debtor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\DebtorPenaltyResource;
use App\Http\Resources\DebtorPenaltyCollection;
use App\Repositories\Interfaces\DebtorPenaltyRepositoryInterface;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use Auth;
use Gate;

class ViewDebtorController extends Controller
{
    /**
    * DebtorPenalty Repository class
    * @var obj
    */
    protected $debtor;

    /**
    * Admin Repository class
    * @var obj
    */
    protected $admin;

    /**
    * Initialise Controller
    */
    public function __construct(AdminRepositoryInterface $admin,
     DebtorPenaltyRepositoryInterface $debtor) {
        $this->middleware('auth:school_api');

        $this->admin = $admin;
        $this->debtor = $debtor;
    }

    /**
    * Retrieve all Debtors from a School
    *
    * @param Request $request
    * @return Resource 
     */
     public function index(Request $request) {
        if($this->permissionDeny('view-debtor-penalty')){
            return response()->json([
                'message' => 'Permission Denied'
               ],403);
        }

        //Get the school admin id
        $admin_id = Auth::guard('school_api')->id();
        //Get the school_id
        $school_id = $this->admin->find($admin_id)->school_id;

        $query = $this->debtor->setDebtor()->query();

        $debtors = $query
        ->select('debtor_penalty.id as id', 'debtor_penalty.issue as issue', 'debtor_penalty.status as status', 'students.id as student_id', 'students.surname as surname', 'students.firstname as firstname', 'students.middlename as middlename', 'classes.class_name as clas', 'class_arms.class_arm as arm')
        ->where('debtor_penalty.school_id', $school_id)
        ->leftJoin('students', 'debtor_penalty.student_id', '=', 'students.id')
        ->leftJoin('classarm_student', 'students.id', '=', 'classarm_student.student_id')
        ->leftJoin('class_arms', 'class_arms.id', '=', 'classarm_student.classarm_id')
        ->leftJoin('classes', 'class_arms.class_id', '=', 'classes.id')
        ->when($request->query('query'), function ($q, $query) { 
            return $q->where(function ($q) use ($query) { 
                $q->where('students.surname', 'like', '%'.$query.'%')
                ->orWhere('students.firstname', 'like', '%'.$query.'%')
                ->orWhere('students.middlename', 'like', '%'.$query.'%');
            });
        })
        ->orderBy('students.surname', 'asc')
        ->orderBy('students.firstname', 'asc')
        ->orderBy('students.middlename', 'asc')
        ->paginate(20)
        ->appends($request->query());

        return new DebtorPenaltyCollection($debtors);
    }

    protected function permissionDeny($ability){
        Auth::shouldUse('school_api');
        return Gate::denies($ability);
    }
}
