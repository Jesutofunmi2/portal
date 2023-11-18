<?php

namespace App\Http\Controllers\Admins\Permission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\PermissionCollection;
use App\Repositories\Interfaces\PermissionRepositoryInterface;
use Auth;
use Gate;

class ViewPermissionController extends Controller
{
    /**
    * Permission Repository class
    * @var obj
    */
    protected $permission;

    /**
    * Initialise Controller
    */
    public function __construct(PermissionRepositoryInterface $permission) {
        $this->middleware('auth:school_api');

        $this->permission = $permission;
    }

    /**
    * Retrieve all Permissions for a School Admin
    *
    * @param Request $request
    * @return Resource 
    */
    public function index() {

        $adminPermissions = [1,2,3,4,5,6,7,8,9,10,11,12,13,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,55,55,56,57];

        $permissions = $this->permission
        ->setPermission()
        ->whereIn('id', $adminPermissions)
        ->orderBy('permission', 'asc')
        ->get();

        return new PermissionCollection($permissions);
    }

    protected function permissionDeny($ability){
        Auth::shouldUse('school_api');
        return Gate::denies($ability);
    }
}