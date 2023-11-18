<?php

namespace App\Http\Controllers\Ministry\User;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\SuperAdminRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class CreateMinistryAccount extends Controller
{
    protected $aeozeo;
    protected $superadmin;

    public function __construct(SuperAdminRepositoryInterface $superadmin) {

        $this->superadmin = $superadmin;

        $this->middleware('auth:ministry_api');
    }

    public function index(Request $request)
    {
        if($this->permissionDeny('create-user')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
        }

        $this->validateTopMinistryUser();

        $admins = $this->superadmin->setSuperAdmin();

        $this->validate($request,$admins::$rules);

        $request->merge([
            'password' => Hash::make($request->password),
            'status' => 1
        ]);

        $admins->create($request->all());

        return Response::json([
            'data' => [
                'message' => 'User Created Successfully'
            ]
        ]);
    }

    public function createAeozeo(Request $request)
    {
        if($this->permissionDeny('create-user')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
        }

        $this->validateTopMinistryUser();

        $admins = $this->superadmin->setSuperAdmin();

        $this->validate($request, $admins::$rules);

        $request->merge([
            'password' => Hash::make($request->password),
            'status' => 1,
            'is_aeozeo' => true
        ]);

        $admins->create($request->all());

        return Response::json([
            'data' => [
                'message' => 'User Created Successfully'
            ]
        ]);
    }

    public function createCasAdmin(Request $request)
    {
        if($this->permissionDeny('create-user')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
        }

        $admins = $this->superadmin->setSuperAdmin();

        $this->validate($request, $admins::$rules);

        $request->merge([
            'password' => Hash::make($request->password),
            'status' => 1,
            'is_cas_admin' => true
        ]);

        $admins->create($request->all());

        return Response::json([
            'data' => [
                'message' => 'User Created Successfully'
            ]
        ]);
    }
    
    protected function validateTopMinistryUser() {
        $ministry_admin_id = Auth::guard('ministry_api')->id();
        if($ministry_admin_id != 2){
            return response()->json([
                'message' => 'Permission Denied'
            ],403);
        }
    }

    protected function permissionDeny($ability){
        Auth::shouldUse('ministry_api');
        return Gate::denies($ability);
    }
}
