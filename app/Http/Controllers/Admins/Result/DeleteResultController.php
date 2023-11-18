<?php

namespace App\Http\Controllers\Admins\Result;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Gate;

class DeleteResultController extends Controller
{
    public function __construct() {

        $this->middleware('auth:school_api');
        
    }

    /**
    * Delete a Result
    * 
    * @param int $id
    * @return Json
    */
    public function index($id=null) {
        if($this->permissionDeny('delete-student-result')){
            return response()->json([
                'message' => 'Permission Denied'
               ],403);
        }

        DB::table('student_results')
        ->where('id', $id)
        ->delete();

        return response()->json([
            'data' => [
                'message' => 'Result Deleted successfully'
            ]
        ]);
    }

    protected function permissionDeny($ability){
        Auth::shouldUse('school_api');
        return Gate::denies($ability);
    }
}