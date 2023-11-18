<?php

namespace App\Http\Controllers\Ministry\Permission;

use App\Http\Controllers\Controller;
use App\Http\Resources\MinistryAdminResource;
use App\Models\Permission;
use App\Repositories\Interfaces\PermissionRepositoryInterface;
use App\Repositories\Interfaces\SuperAdminRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class MinistryPermissionController extends Controller
{
    protected $superadmin;

    protected $permission;

    public function __construct(SuperAdminRepositoryInterface $superadmin,
                                PermissionRepositoryInterface $permission
        ) {

        $this->superadmin = $superadmin;

        $this->permission = $permission;

        $this->middleware('auth:ministry_api');
    }


    public function getAdmins(Request $request)
    {
        if($this->permissionDeny('view-user')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
        }

        if(! $this->validateTopMinistryUser()) {
            return response()->json([
                'message' => 'Permission Denied'
            ],403);
        }

        $this->validate($request,['query' => 'sometimes|string']);

        $admins = $this->superadmin->setSuperAdmin();
        $all_admins = $admins->query()
            ->where('is_aeozeo', false)
            ->when(
                $request->query('query'), 
                function (Builder $query, $term) {
                    return $query->where('fullname', 'like' ,'%'.$term.'%')->orWhere('username', 'like' ,'%'.$term.'%');
                } 
            )
            ->paginate(40);
            
        return MinistryAdminResource::collection($all_admins);
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
        $admin = $this->superadmin->setSuperAdmin();

        $admin = $admin->find($request->id,['id','fullname','username']);

        foreach ($allPerms as $perm) {
            //check teacher permission where permission id and  teacher id exists
            $userPerm = DB::table('super_admin_permission')->where(['permission_id' => $perm->id, 'super_admin_id' => $request->id])->first();
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
        
        if(DB::table('super_admin_permission')->where('super_admin_id', $request->id)->exists()){
            DB::table('super_admin_permission')->where('super_admin_id', $request->id)->delete();
        }

        if($request->state == 'ADD'){
            $permits = array();
            $allPerms = $this->permission;
            $allPerms = $allPerms->getAll();

            foreach ($allPerms as $perm) {
                $permits[] = array(
                    'super_admin_id' => $request->id,
                    'permission_id' => $perm->id,
                );
            }
            DB::table('super_admin_permission')->insert($permits);

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
            if(DB::table('super_admin_permission')->where([
                'super_admin_id' => $request->id,
                'permission_id' => $request->permission_id,
                ])->exists()){
               
                    return response()->json([
                        'data' => [
                            'message' => 'User already has this permission',       
                            ]
                    ], 200);
            }
            DB::table('super_admin_permission')->insert([
                'super_admin_id' => $request->id,
                'permission_id' => $request->permission_id,
            ]);

            return response()->json([
                'data' => [
                    'message' => 'User has been given permisssion',       
                    ]
            ], 200);
        }
        if($request->state == 'REMOVE'){
            if(DB::table('super_admin_permission')->where([
                'super_admin_id' => $request->id,
                'permission_id' => $request->permission_id,
                ])->exists())
                {

                DB::table('super_admin_permission')->where([
                    'super_admin_id' => $request->id,
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

    protected function permissionDeny($ability){
        Auth::shouldUse('ministry_api');
        return Gate::denies($ability);
    }
}
