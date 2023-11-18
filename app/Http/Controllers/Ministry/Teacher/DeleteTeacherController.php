<?php

namespace App\Http\Controllers\Ministry\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\TeacherRepositoryInterface;
use App\Http\Resources\ViewTeacherResource;
use Auth;
use Gate;


class DeleteTeacherController extends Controller
{
    protected $teachers;

    public function __construct(TeacherRepositoryInterface $teachers) 
    {
        $this->teachers = $teachers;

        $this->middleware('auth:ministry_api');
    }

    public function index($id=null)
    {
        if($this->permissionDeny('delete-teacher')){
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


        $teacher = $this->teachers->find($id);


        $teacher->subjects()->detach();
        $teacher->delete();

        return response()->json([
            'data' => [
                'message' => 'Teacher Deleted successfully'
            ]
        ]);

    }

    protected function permissionDeny($ability){
        Auth::shouldUse('ministry_api');
        return Gate::denies($ability);
    }
}
