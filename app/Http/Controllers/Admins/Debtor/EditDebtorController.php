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

class EditDebtorController extends Controller
{
    /**
    * @var obj
    */
    protected $debtor;

    /**
    * @var obj
    */
    protected $admin;

    public function __construct(DebtorPenaltyRepositoryInterface $debtor, AdminRepositoryInterface $admin) {

        $this->middleware('auth:school_api');

        $this->debtor = $debtor;

        $this->admin = $admin;
    }

    /**
    * Retrieve Debtor to be Edited
    *
    * @param Request $request
    * @param int $id
    * @return json Resource
    */
    public function index(Request $request, $id)
    {
        if($this->permissionDeny('status-debtor-penalty')){
            return response()->json([
                'message' => 'Permission Denied'
               ],403);
        }

        $debtor = $this->debtor->find($id);
        
        return new DebtorPenaltyResource($debtor);

    }

    /**
    * Update Debtor Details
    *
    * @param Request $request
    * @param Int $id
    * @return json
    */
    public function update(Request $request, $id)
    {
        if($this->permissionDeny('status-debtor-penalty')){
            return response()->json([
                'message' => 'Permission Denied'
               ],403);
        }

        //Get the school admin id
        $admin_id = Auth::guard('school_api')->id();
        //Get the school_id
        $school_id = $this->admin->find($admin_id)->school_id;

        $setDebtor = $this->debtor->find($id);

        $rule = ['issue' => 'required|string',
                'status' => 'required|int',
        ];

        $this->validate($request, $rule);
        
        $setDebtor->issue = $request->input('issue');
        $setDebtor->status = $request->input('status');
        $setDebtor->save();

        return response()->json([
            'data' => [
                'message' => 'Debtor status updated successfully'
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
