<?php

namespace App\Http\Controllers\Ministry\SchoolAdmin;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use App\Repositories\Interfaces\SuperAdminRepositoryInterface;
use App\Http\Controllers\Controller;
use Auth;
use Gate;
use Illuminate\Support\Facades\Hash;

class CreateSchoolAdminController extends Controller
{
    //
    protected $admin;

    protected $superadmin;

    public function __construct(AdminRepositoryInterface $admin,
                                SuperAdminRepositoryInterface $superadmin)
        {

        $this->middleware('auth:ministry_api');

        $this->admin = $admin;

        $this->superadmin = $superadmin;

    }


    public function index(Request $request)
    {
        
        if($this->permissionDeny('create-school-admin')){
           return response()->json([
            'message' => 'Permission Denied'
           ],403);
        }
        
        $setSchoolAdmin = $this->admin->setAdmin();

        $superadmin = $this->superadmin->setSuperAdmin();

        unset($setSchoolAdmin::$rules['permissions']);

        $this->validate($request, $setSchoolAdmin::$rules);
 
        $school_admin = $setSchoolAdmin->create([
            'fullname' => $request->input('fullname'),
            'email' => $request->input('email'),
            'username' => $request->input('username'),
            'school_id' => $request->input('school'),
            'status' => 1,
            'phone' => $request->input('phone'),
            'password' => Hash::make($request->input('password'))
        ]);

        $school_admin->permissions()->attach($superadmin::$schoolAdminPermissions);


        return response()->json([
            'data' => [
                'message' => 'Admin created successfully'
            ]
        ]);

    }

    protected function permissionDeny($ability){
        Auth::shouldUse('ministry_api');
        return Gate::denies($ability);
    }
}
