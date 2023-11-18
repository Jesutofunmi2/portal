<?php

namespace App\Http\Controllers\Admins\ClassArm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\ClassArmRepositoryInterface;
use Auth;
use Gate;

class DeleteClassArmController extends Controller
{
    //
    protected $classarm;

    public function __construct(ClassArmRepositoryInterface $classarm)
    {

    $this->middleware('auth:school_api');

    $this->classarm = $classarm;

    }


    public function index($id=null)
    {
        if($this->permissionDeny('delete-classarm')){
            return response()->json([
                'message' => 'Permission Denied'
               ],403);
        }
            
        $classarm = $this->classarm->find($id);

        $classarm->delete();

        return response()->json([
            'data' => [
                'message' => 'Class Arm Deleted successfully'
            ]
        ]);

    }

    protected function permissionDeny($ability){
        Auth::shouldUse('school_api');
        return Gate::denies($ability);
    }
}
