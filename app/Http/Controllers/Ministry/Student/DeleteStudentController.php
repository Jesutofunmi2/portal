<?php

namespace App\Http\Controllers\Ministry\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use App\Http\Resources\ViewTeacherResource;
use Auth;
use Gate;


class DeleteStudentController extends Controller
{
    protected $students;

    public function __construct(StudentRepositoryInterface $students) 
    {
        $this->students = $students;

        $this->middleware('auth:ministry_api');
    }

    public function index($id=null)
    {
        if($this->permissionDeny('delete-student')){
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

        $student = $this->students->find($id);

        $student->classarms()->detach();
        $student->delete();

        return response()->json([
            'data' => [
                'message' => 'Student Deleted Successfully'
            ]
            ],200);

    }

    protected function permissionDeny($ability){
        Auth::shouldUse('ministry_api');
        return Gate::denies($ability);
    }
}
