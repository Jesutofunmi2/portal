<?php

namespace App\Http\Controllers\Admins\ClassArm;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\ClassArmRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class DeleteClassArmSubjectController extends Controller
{
    //
    protected $classarm;

    public function __construct(ClassArmRepositoryInterface $classarm)
    {

    $this->middleware('auth:school_api');

    $this->classarm = $classarm;

    }


    public function index($id = null)
    {
        if($this->permissionDeny('remove-assign-subject-to-classarm')){
            return response()->json([
                'message' => 'Permission Denied'
               ],403);
        }
            
        $classarm = $this->classarm->find($id);

        //Detach all Subjects from the Class Arm
        $classarm->subjects()->detach();

        return response()->json([
            'data' => [
                'message' => 'Class Arm Subjects Deleted successfully'
            ]
        ]);

    }

    protected function permissionDeny($ability){
        Auth::shouldUse('school_api');
        return Gate::denies($ability);
    }
}
