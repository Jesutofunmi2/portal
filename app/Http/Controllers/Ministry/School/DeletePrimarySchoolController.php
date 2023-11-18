<?php

namespace App\Http\Controllers\Ministry\School;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Gate;
use App\Models\PrimarySchool;

class DeletePrimarySchoolController extends Controller
{
    //
    protected $school;

    public function __construct() {

        $this->middleware('auth:ministry_api');

    }


    public function index($id=null)
    {
        if($this->permissionDeny('delete-school')){
            return response()->json([
                'message' => 'Permission Denied'
               ],403);
        }
            
        PrimarySchool::findOrFail($id)->delete();
    


        return response()->json([
            'data' => [
                'message' => 'School Deleted successfully'
            ]
        ]);

    }

    protected function permissionDeny($ability){
        Auth::shouldUse('ministry_api');
        return Gate::denies($ability);
    }
}
