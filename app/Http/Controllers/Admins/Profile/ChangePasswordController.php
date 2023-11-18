<?php

namespace App\Http\Controllers\Admins\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Auth;
use Gate;

class ChangePasswordController extends Controller
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
        if($this->permissionDeny('edit-user')){
           return response()->json([
            'message' => 'Permission Denied'
           ],403);
        }

        //Get the school admin id
        $admin_id = Auth::guard('school_api')->id();

        $setAdmin = $this->admin->find($admin_id);
        if($setAdmin){

            $setSchoolAdmin = $this->admin->setAdmin();

            $rules = [
                'password' => 'required|alpha_num|min:6|confirmed',
                'password_confirmation' => 'required',
            ];

            $this->validate($request, $rules);
        
            $setAdmin->update([
                    'password' => Hash::make($request->input('password')),
            ]);

            return response()->json([
                'data' => [
                    'message' => 'Password changed successfully'
                ]
            ]);
        }
    }

    protected function permissionDeny($ability) 
    {
        Auth::shouldUse('school_api');
        return Gate::denies($ability);
    }
}