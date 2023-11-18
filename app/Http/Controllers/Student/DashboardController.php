<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    //
    protected $student;

    public function __construct(StudentRepositoryInterface $student)
    {

        $this->middleware('auth:student_api');

        $this->teach = $student;

    }

    public function index()
    {
        //Get the student id
        $student_id = Auth::guard('student_api')->id();
        
        $student = $this->teach->setStudent()->find($student_id);
        $state = $student->state;
        $statelga = $student->statelga;

        return response()->json([
            'student' => $student,
            'state' => $state ? $state->name : null,
            'statelga' => $statelga ? $statelga->name : null,
        ]);

    }
}