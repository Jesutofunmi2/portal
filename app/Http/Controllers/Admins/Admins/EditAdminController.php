<?php

namespace App\Http\Controllers\Admins\Admins;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use App\Http\Resources\SchoolAdminResource;
use Auth;
use Gate;

class EditAdminController extends Controller
{
    //
    protected $admin;

    public function __construct(AdminRepositoryInterface $admin)
    {

        $this->middleware('auth:school_api');

        $this->admin = $admin;

    }

    public function index($id = null)
    {
        
        if($this->permissionDeny('edit-user')){
           return response()->json([
            'message' => 'Permission Denied'
           ],403);
        }
        
        $admin = $this->admin->setAdmin()
        ->with('permissions')
        ->find($id);

        return response()->json([
            'data' => $admin,
        ]);

    }

    public function update(Request $request, $id = null)
    {
        $setAdmin = $this->admin->find($id);
        if($setAdmin){

            $setSchoolAdmin = $this->admin->setAdmin();

            unset($setSchoolAdmin::$rules['password']);
    
            unset($setSchoolAdmin::$rules['password_confirmation']);
    
            unset($setSchoolAdmin::$rules['school']);
    
            $setSchoolAdmin::$rules['email'] = 'required|email|unique:admins,email,'.$id;
            $setSchoolAdmin::$rules['username'] = 'required|min:4|unique:admins,username,'.$id;
            $setSchoolAdmin::$rules['phone'] = 'required|regex:(234?)|digits:13|unique:admins,phone,'.$id;
            $setSchoolAdmin::$rules['permissions'] = 'nullable';
    
            $setAdmin->update([
                    'fullname' => $request->input('fullname'),
                    'email' => $request->input('email'),
                    'username' => $request->input('username'),
                    'phone' => $request->input('phone')
            ]);

            if ($request->input('permissions')) {
                $permissions = json_decode($request->input('permissions'));

                $setAdmin->permissions()->sync($permissions);
            }

            return response()->json([
                'data' => [
                    'message' => 'Admin updated successfully'
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