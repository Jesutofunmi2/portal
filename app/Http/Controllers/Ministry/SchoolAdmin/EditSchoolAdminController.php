<?php

namespace App\Http\Controllers\Ministry\SchoolAdmin;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use App\Http\Controllers\Controller;
use Auth;
use Gate;
use App\Http\Resources\MinistrySchoolAdminResource;


class EditSchoolAdminController extends Controller
{
    //
    protected $admin;

    public function __construct(AdminRepositoryInterface $admin)
        {

        $this->middleware('auth:ministry_api');

        $this->admin = $admin;

    }


    public function index($id=null)
    {
        
        if($this->permissionDeny('edit-school-admin')){
           return response()->json([
            'message' => 'Permission Denied'
           ],403);
        }
        
        $admin = $this->admin->find($id);

        return new MinistrySchoolAdminResource($admin);

    }

    public function update(Request $request, $id = null)
    {
        if($this->permissionDeny('edit-school-admin')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
         }

        $setSchool = $this->admin->find($id);
        if($setSchool){

            $setSchoolAdmin = $this->admin->setAdmin();

            unset($setSchoolAdmin::$rules['password']);
    
            unset($setSchoolAdmin::$rules['password_confirmation']);
    
            unset($setSchoolAdmin::$rules['permissions']);
    
            $setSchoolAdmin::$rules['email'] = 'required|email|unique:admins,email,'.$id;
            $setSchoolAdmin::$rules['username'] = 'required|min:4|unique:admins,username,'.$id;
            $setSchoolAdmin::$rules['phone'] = 'required|regex:(234?)|digits:13|unique:admins,phone,'.$id;
    
            $request->validate($setSchoolAdmin::$rules);

                $setSchool->update([
                        'fullname' => $request->input('fullname'),
                        'email' => $request->input('email'),
                        'username' => $request->input('username'),
                        'school_id' => $request->input('school'),
                        'phone' => $request->input('phone')
                ]);

            return response()->json([
                'data' => [
                    'message' => 'School updated successfully'
                ]
            ]);
        }


    }

    protected function permissionDeny($ability){
        Auth::shouldUse('ministry_api');
        return Gate::denies($ability);
    }
}
