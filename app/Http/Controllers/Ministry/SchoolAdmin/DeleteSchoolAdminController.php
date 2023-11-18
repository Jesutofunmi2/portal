<?php

namespace App\Http\Controllers\Ministry\SchoolAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Gate;
use App\Repositories\Interfaces\AdminRepositoryInterface;

class DeleteSchoolAdminController extends Controller
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
        if($this->permissionDeny('delete-school-admin')){
            return response()->json([
                'message' => 'Permission Denied'
               ],403);
        }

        if(!is_numeric($id)){
            return response()->json([
                'data' => [
                    'message' => 'Invalid ID'
                ]
            ]);
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
        Auth::shouldUse('ministry_api');
        return Gate::denies($ability);
    }
}
