<?php

namespace App\Http\Controllers\Teacher\Subject;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\TeacherRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Auth;
use Gate;

class DeleteSubjectController extends Controller
{
    //
    protected $teach;

    public function __construct(TeacherRepositoryInterface $teacher)
    {

        $this->middleware('auth:teacher_api');

        $this->teach = $teacher;

    }


    public function index($id = null)
    {
        /*
        if($this->permissionDeny('delete-student')){
            return response()->json([
                'message' => 'Permission Denied'
               ],403);
        }
        */
            
        //Get the teacher id
        $teach_id = Auth::guard('teacher_api')->id();
        //Get Teacher
        $teach = $this->teach->find($teach_id);

        //Remove subject from teacher
        $teach->subjects()->detach($id);

        return response()->json([
            'data' => [
                'message' => 'Subject Deleted successfully'
            ]
        ]);

    }

    protected function permissionDeny($ability){
        Auth::shouldUse('teacher_api');
        return Gate::denies($ability);
    }
}
