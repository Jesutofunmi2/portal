<?php

namespace App\Http\Controllers\Admins\Admins;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use Auth;
use Gate;

class DeleteAdminController extends Controller
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
        if($this->permissionDeny('delete-user')){
            return response()->json([
                'message' => 'Permission Denied'
               ],403);
        }
            
        $admin = $this->admin->find($id);

        $admin->permissions()->detach();

        $admin->delete();

        return response()->json([
            'data' => [
                'message' => 'Admin Deleted successfully'
            ]
        ]);

    }

    protected function permissionDeny($ability){
        Auth::shouldUse('school_api');
        return Gate::denies($ability);
    }
}
