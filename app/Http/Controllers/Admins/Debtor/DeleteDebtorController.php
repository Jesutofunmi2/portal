<?php

namespace App\Http\Controllers\Admins\Debtor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\DebtorPenaltyRepositoryInterface;
use Auth;
use Gate;

class DeleteDebtorController extends Controller
{
    //
    protected $debtor;

    public function __construct(DebtorPenaltyRepositoryInterface $debtor)
    {

    $this->middleware('auth:school_api');

    $this->debtor = $debtor;

    }


    public function index($id=null)
    {
        if($this->permissionDeny('status-debtor-penalty')){
            return response()->json([
                'message' => 'Permission Denied'
               ],403);
        }
            
        $debtor = $this->debtor->find($id);

        $debtor->delete();

        return response()->json([
            'data' => [
                'message' => 'Debtor data Deleted successfully'
            ]
        ]);

    }

    protected function permissionDeny($ability){
        Auth::shouldUse('school_api');
        return Gate::denies($ability);
    }
}
