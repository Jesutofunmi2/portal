<?php

namespace App\Http\Controllers\Admins\Wallet;

use App\Http\Controllers\Controller;
use App\Http\Resources\WalletResource;
use App\Models\Wallet;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ViewWalletController extends Controller
{
    //
    protected $admin;

    protected $wallet;

    public function __construct(AdminRepositoryInterface $admin) 
    {

        $this->middleware('auth:school_api');

        $this->admin = $admin;

    }

    public function index(Request $request)
    {
        $request->validate([
            'session' => 'required|integer'
        ]);
        //Get the school admin id
        $admin_id = Auth::guard('school_api')->id();
        //Get the school_id
        $school_id = $this->admin->find($admin_id)->school_id;
        $wallet = Wallet::where([
            'school_id' => $school_id,
            'session' => $request->session
        ])->first();        
        
        if (is_null($wallet)) {
            abort(400, "No school wallet found for this session");
        }
        return WalletResource::make($wallet);
    }

    protected function permissionDeny($ability){
        Auth::shouldUse('school_api');
        return Gate::denies($ability);
    }
}