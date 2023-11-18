<?php

namespace App\Http\Controllers\Ministry\Permission;

use App\Http\Controllers\Controller;
use App\Http\Resources\MinistryAdminResource;
use App\Repositories\Interfaces\PermissionRepositoryInterface;
use App\Repositories\Interfaces\SuperAdminRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class AeozeoPermissionController extends Controller
{
    protected $superadmin;

    protected $permission;

    public function __construct(SuperAdminRepositoryInterface $superadmin,
                                PermissionRepositoryInterface $permission) 
    {

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
            ->where('is_aeozeo', true)
            ->when(
                $request->query('query'), 
                function (Builder $query, $term) {
                    return $query->where('fullname', 'like' ,'%'.$term.'%')->orWhere('username', 'like' ,'%'.$term.'%');
                } 
            )
            ->paginate(40);
            
        return MinistryAdminResource::collection($all_admins);
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
