<?php

namespace App\Http\Controllers\Admins\Teacher;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\TeacherRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Auth;
use Gate;

class DeleteTeacherController extends Controller
{
    //
    protected $teacher;

    public function __construct(TeacherRepositoryInterface $teacher)
    {

        $this->middleware('auth:school_api');

        $this->teacher = $teacher;

    }

    public function index($id = null)
    {
        if($this->permissionDeny('delete-teacher')){
            return response()->json([
                'message' => 'Permission Denied'
               ],403);
        }
            
        $teacher = $this->teacher->find($id);

        //Delete Subject Teacher relations
        DB::table('subject_teacher')
        ->where('teacher_id', $id)
        ->delete();

        //Delete ClassArm Teacher relations
        DB::table('classarm_teacher')
        ->where('teacher_id', $id)
        ->delete();

        $teacher->delete();

        return response()->json([
            'data' => [
                'message' => 'Teacher Deleted successfully'
            ]
        ]);

    }

    protected function permissionDeny($ability){
        Auth::shouldUse('school_api');
        return Gate::denies($ability);
    }
}
