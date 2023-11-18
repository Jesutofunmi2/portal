<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\TeacherRepositoryInterface;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    //
    protected $teacher;

    public function __construct(TeacherRepositoryInterface $teacher)
    {

        $this->middleware('auth:teacher_api');

        $this->teach = $teacher;

    }

    public function index()
    {
        //Get the teacher id
        $teach_id = Auth::guard('teacher_api')->id();
        
        $teach = $this->teach->setTeacher()
        ->find($teach_id);
        $state = $teach->state;
        $statelga = $teach->statelga;
        $subjects = $teach->subjects;

        return response()->json([
            'teacher' => $teach,
            'state' => $state ? $state->name : null,
            'statelga' => $statelga ? $statelga->name : null,
            'subjects' => $subjects,
        ]);

    }
}