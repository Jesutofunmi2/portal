<?php

namespace App\Http\Controllers\Admins\Debtor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\DebtorPenaltyResource;
use App\Repositories\Interfaces\DebtorPenaltyRepositoryInterface;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use Illuminate\Validation\Rule;
use Auth;
use Gate;

class AddDebtorController extends Controller
{
    //
    protected $house;
    //
    protected $admin;

    public function __construct(DebtorPenaltyRepositoryInterface $debtor,
     AdminRepositoryInterface $admin) {
        $this->debtor = $debtor;

        $this->admin = $admin;
    }

    /**
    * Create Student House
    * 
    * @param Request $request
    * @return Json
    */
    public function index(Request $request) {
        if($this->permissionDeny('create-debtor-penalty')){
            return response()->json([
                'message' => 'Permission Denied'
               ],403);
        }
        
        $setDebtor = $this->debtor->setDebtor();
        //Get the school admin id
        $admin_id = Auth::guard('school_api')->id();
        //Get the school_id
        $school_id = $this->admin->find($admin_id)->school_id;
        
        $rules = [
            'student_id' => 'required|int',
            'issue' => 'required|string',
        ];

        $this->validate($request, $rules);
        
        $house = $setDebtor->create([
            'student_id' => $request->input('student_id'),
            'school_id' => $school_id,
            'issue' => $request->input('issue'),
            'status' => 0,
        ]);

        return response()->json([
            'data' => [
                'message' => "Debtor Added successfully"
            ]
        ]);
    }

    /**
    * Check for avility to perform action
    * 
    * @param string $ability
    * @return Gate
    */
    protected function permissionDeny($ability){
        Auth::shouldUse('school_api');
        return Gate::denies($ability);
    }
}
