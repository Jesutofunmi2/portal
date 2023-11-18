<?php

namespace App\Http\Controllers\Admins\Clas;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\ClassRepositoryInterface;
use Auth;
use Gate;

class DeleteClassController extends Controller
{
    //
    protected $clas;

    public function __construct(ClassRepositoryInterface $clas)
    {

    $this->middleware('auth:school_api');

    $this->clas = $clas;

    }


    public function index($id=null)
    {
        if($this->permissionDeny('delete-class')){
            return response()->json([
                'message' => 'Permission Denied'
               ],403);
        }
            
        $clas = $this->clas->find($id);

        //Check if Class Arms are attached to the Class
        if ($clas->class_arms->count() > 0) {

            return response()->json([
                'message' => 'Class Arms still attached'
            ], 422);

        } else {

            $clas->delete();

            return response()->json([
                'data' => [
                    'message' => 'Class Deleted successfully'
                ]
            ]);

        }

    }

    protected function permissionDeny($ability){
        Auth::shouldUse('school_api');
        return Gate::denies($ability);
    }
}
