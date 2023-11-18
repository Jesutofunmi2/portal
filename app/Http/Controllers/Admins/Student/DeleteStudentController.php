<?php

namespace App\Http\Controllers\Admins\Student;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class DeleteStudentController extends Controller
{
    //
    protected $student;

    public function __construct(StudentRepositoryInterface $student)
    {

    $this->middleware('auth:school_api');

    $this->student = $student;

    }


    public function index($id=null)
    {
        if($this->permissionDeny('delete-student')){
            return response()->json([
                'message' => 'Permission Denied'
               ],403);
        }
            
        $student = $this->student->find($id);

        $student->delete();

        //Delete Association with Class Arm
        DB::table('classarm_student')
        ->where('student_id', $id)
        ->delete();

        return response()->json([
            'data' => [
                'message' => 'Student Deleted successfully'
            ]
        ]);

    }

    protected function permissionDeny($ability){
        Auth::shouldUse('school_api');
        return Gate::denies($ability);
    }
}
