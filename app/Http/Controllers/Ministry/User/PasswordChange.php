<?php

namespace App\Http\Controllers\Ministry\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\SuperAdminRepositoryInterface;
use App\Http\Resources\MinistryAdminResource;
use Illuminate\Support\Facades\DB;
use Auth;
use Gate;
use Hash;
use Response;

class PasswordChange extends Controller
{
    protected $superadmin;

    public function __construct(SuperAdminRepositoryInterface $superadmin) {

        $this->superadmin = $superadmin;

        $this->middleware('auth:ministry_api');
        $this->validateTopMinistryUser();

    }


    public function index(Request $request)
    {
        $admins = $this->superadmin->setSuperAdmin();

        $this->validate($request,[
            'current_password' => 'required|string',
            'password' => 'required|alpha_num|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);

        if( ! $this->confirmCurrentPassword($request)){
            return Response::json([
                'data' => [
                    'message' => 'Incorrect Current Password'
                ]],400);
        }

        $admins->find( Auth::guard('ministry_api')->id() )->update([
            'password' => Hash::make($request->password)
        ]);

        return Response::json([
            'data' => [
                'message' => 'Password Changed Successfully'
            ]
        ]);
    }
    
    protected function validateTopMinistryUser(){
        $ministry_admin_id = Auth::guard('ministry_api')->id();
        if($ministry_admin_id != 2){
            return response()->json([
                'message' => 'Permission Denied'
            ],403);
        }
    }

    protected function confirmCurrentPassword(Request $request): bool
    {
        $admins = $this->superadmin->setSuperAdmin();
        $ministry_admin_password =  $admins->find( Auth::guard('ministry_api')->id(), ['password'] )->password;
        
        if(Hash::check($request->current_password, $ministry_admin_password)) return true;

        return false;
    }
}
