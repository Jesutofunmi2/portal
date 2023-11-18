<?php

namespace App\Http\Controllers\Teacher\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\TeacherRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Auth;
use Gate;

class ChangePasswordController extends Controller
{
    //
    protected $teach;

    public function __construct(TeacherRepositoryInterface $teacher)
    {

        $this->middleware('auth:teacher_api');

        $this->teach = $teacher;

    }

    public function index(Request $request)
    {
        //Get the teacher id
        $teach_id = Auth::guard('teacher_api')->id();

        $setTeacher = $this->teach->find($teach_id);
        if($setTeacher) {

            $rules = [
                'password' => 'required|alpha_num|min:6|confirmed',
                'password_confirmation' => 'required',
            ];
    
            $this->validate($request, $rules);

            $setTeacher->update([
                    'password' => Hash::make($request->input('password')),
            ]);

            return response()->json([
                'data' => [
                    'message' => 'Password changed successfully'
                ]
            ]);
        }
    }

    protected function permissionDeny($ability) 
    {
        Auth::shouldUse('teacher_api');
        return Gate::denies($ability);
    }
}