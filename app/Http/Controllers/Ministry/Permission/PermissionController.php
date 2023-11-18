<?php

namespace App\Http\Controllers\Ministry\Permission;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\SuperAdminRepositoryInterface;
use App\Repositories\Interfaces\PermissionRepositoryInterface;
use App\Http\Resources\MinistryAdminResource;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;
use Auth;
use Gate;

class PermissionController extends Controller
{
    protected $permission;

    public function __construct(PermissionRepositoryInterface $permission) {

        $this->permission = $permission;

        $this->middleware('auth:ministry_api');
    }
   
    public function getAllPermission(Request $request)
    {
        if(! $this->validateTopMinistryUser()) {
            return response()->json([
                'message' => 'Permission Denied'
            ],403);
        }

        $allPerms = $this->permission;
        $allPerms = $allPerms->getAll();

        return response()->json([
            'data' => [
                'permissions' => $allPerms        
                ]
        ], 200);

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
