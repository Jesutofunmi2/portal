<?php

namespace App\Http\Controllers\Admins\Admins;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Auth;
use Gate;

class CreateAdminController extends Controller
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
        
        if($this->permissionDeny('create-user')){
           return response()->json([
            'message' => 'Permission Denied'
           ],403);
        }
        
        $setAdmin = $this->admin->setAdmin();

        unset($setAdmin::$rules['permissions']);
        unset($setAdmin::$rules['school']);

        $this->validate($request, $setAdmin::$rules);

        //Get the Logged in school admin id
        $admin_id = Auth::guard('school_api')->id();
        //Get the school_id
        $school_id = $this->admin->find($admin_id)->school_id;
 
        $school_admin = $setAdmin->create([
            'fullname' => $request->input('fullname'),
            'email' => $request->input('email'),
            'username' => $request->input('username'),
            'school_id' => $school_id,
            'status' => 1,
            'phone' => $request->input('phone'),
            'password' => Hash::make($request->input('password'))
        ]);

        return response()->json([
            'data' => [
                'message' => 'Admin User created successfully'
            ]
        ]);

    }

    protected function permissionDeny($ability){
        Auth::shouldUse('school_api');
        return Gate::denies($ability);
    }
}
