<?php

namespace App\Http\Controllers\Ministry\Permission;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use App\Repositories\Interfaces\PermissionRepositoryInterface;
use App\Http\Resources\MinistrySchoolAdminResource;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;
use Auth;
use Gate;

class SchoolAdminPermissionController extends Controller
{
    protected $admin;

    protected $permission;

    public function __construct(AdminRepositoryInterface $admin,
                                PermissionRepositoryInterface $permission
        ) {

        $this->admin = $admin;

        $this->permission = $permission;

        $this->middleware('auth:ministry_api');

    }


    public function getAdmins(Request $request)
    {
        if(! $this->validateTopMinistryUser()) {
            return response()->json([
                'message' => 'Permission Denied'
            ],403);
        }

        $this->validate($request,[
            'query' => 'sometimes|string',
            'school_id' => 'sometimes|integer'
            ]);

        $query = $this->admin->setAdmin()->query()
        ->when($request->query('school_id'), function ($q, $school_id) { 
            return $q->where('school_id', $school_id);})
        ->when($request->query('query'), function ($q, $query) { 
            return $q->where('fullname', 'like', '%'.$query.'%')->orWhere('username', 'like', '%'.$query.'%')->orWhere('email', 'like', '%'.$query.'%');
        })
        ->orderBy('id','desc')->paginate(40);
            
        return MinistrySchoolAdminResource::collection($query);
    }
   
    public function getPermission(Request $request)
    {
        if(! $this->validateTopMinistryUser()) {
            return response()->json([
                'message' => 'Permission Denied'
            ],403);
        }

        $this->validate($request, ['id' => 'required|integer']);

        $permits = array();
        $allPerms = $this->permission;
        $allPerms = $allPerms->getAll();
        $admin = $this->admin->setAdmin();

        $admin = $admin->find($request->id,['id','fullname','username']);

        foreach ($allPerms as $perm) {
            //check teacher permission where permission id and  teacher id exists
            $userPerm = DB::table('admin_permission')->where(['permission_id' => $perm->id, 'admin_id' => $request->id])->first();
            if($userPerm){
                $permits[] = array(
                    'id' => $perm->id,
                    'permission' => $perm->permission,
                    'status' => 'checked',
                );
            }else{
                $permits[] = array(
                    'id' => $perm->id,
                    'permission' => $perm->permission,
                    'status' => 'unchecked',
                );
            }
        }

        return response()->json([
            'data' => [
                'admin' => $admin,
                'permissions' => $permits        
                ]
        ], 200);

    }

    public function toggleAllPermission(Request $request)
    {
        if(! $this->validateTopMinistryUser()) {
            return response()->json([
                'message' => 'Permission Denied'
            ],403);
        }

        $this->validate($request, [
            'id' => 'required|integer',
            'state' => 'required|string'
            ]);
        
        if(DB::table('admin_permission')->where('admin_id', $request->id)->exists()){
            DB::table('admin_permission')->where('admin_id', $request->id)->delete();
        }

        if($request->state == 'ADD'){
            $permits = array();
            $allPerms = $this->permission;
            $allPerms = $allPerms->getAll();

            foreach ($allPerms as $perm) {
                $permits[] = array(
                    'admin_id' => $request->id,
                    'permission_id' => $perm->id,
                );
            }
            DB::table('admin_permission')->insert($permits);

            return response()->json([
                'data' => [
                    'message' => 'User has been given all permisssions',       
                    ]
            ], 200);
        }
        if($request->state == 'REMOVE'){
            return response()->json([
                'data' => [
                    'message' => 'All user\'s permission has been removed',       
                    ]
            ], 200);
        }

        
    }
    
    public function toggleSomePermission(Request $request)
    {
        if(! $this->validateTopMinistryUser()) {
            return response()->json([
                'message' => 'Permission Denied'
            ],403);
        }

        $this->validate($request, [
            'id' => 'required|integer',
            'permission_id' => 'required|integer',
            'state' => 'required|string'
            ]);

        if($request->state == 'ADD'){
            if(DB::table('admin_permission')->where([
                'admin_id' => $request->id,
                'permission_id' => $request->permission_id,
                ])->exists()){
               
                    return response()->json([
                        'data' => [
                            'message' => 'User already has this permission',       
                            ]
                    ], 200);
            }
            DB::table('admin_permission')->insert([
                'admin_id' => $request->id,
                'permission_id' => $request->permission_id,
            ]);

            return response()->json([
                'data' => [
                    'message' => 'User has been given permisssion',       
                    ]
            ], 200);
        }
        if($request->state == 'REMOVE'){
            if(DB::table('admin_permission')->where([
                'admin_id' => $request->id,
                'permission_id' => $request->permission_id,
                ])->exists())
                {

                DB::table('admin_permission')->where([
                    'admin_id' => $request->id,
                    'permission_id' => $request->permission_id,
                    ])->delete();

                }
            return response()->json([
                'data' => [
                    'message' => 'User permission has been removed',       
                    ]
            ], 200);
        }

        
    }
    protected function validateTopMinistryUser(): Bool
    {
        $ministry_admin_id = Auth::guard('ministry_api')->id();

        if($ministry_admin_id != 2){
            return false;
        }
        return true;
    }
}
