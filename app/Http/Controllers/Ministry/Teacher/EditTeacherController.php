<?php

namespace App\Http\Controllers\Ministry\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\TeacherRepositoryInterface;
use App\Http\Resources\MinistryShowTeacherResource;
use Auth;
use Gate;
use Hash;


class EditTeacherController extends Controller
{
    protected $teachers;

    public function __construct(TeacherRepositoryInterface $teachers) 
    {
        $this->teachers = $teachers;

        $this->middleware('auth:ministry_api');
    }

    public function index($id=null)
    {
        if($this->permissionDeny('edit-teacher')){
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

        return new MinistryShowTeacherResource($teacher);

    }

    public function update(Request $request, $id='')
    {
        if($this->permissionDeny('edit-teacher')){
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

        $teacher_update = $this->teachers->find($id);

        $teacher = $this->teachers->setTeacher();

        $teacher::$rules['password'] = 'sometimes|alpha_num|min:6|confirmed';

        $teacher::$rules['password_confirmation'] = 'sometimes|alpha_num|min:6';
        $teacher::$rules['email'] = 'required|email|unique:teachers,email,'.$teacher_update->id;
        $teacher::$rules['phone'] = 'required|unique:teachers,phone,'.$teacher_update->id.'|regex:(234?)';
        
        $teacher::$rules['parent_email'] = '';

        $this->validate($request, $teacher::$rules);

        $teacher_update->subjects()->detach();

       if(isset($request->password)) {
           $password = Hash::make($request->password);
       }else{
           $password = $teacher_update->password;
       }

    $teacher_update->update([
        'title' => $request->title,
        'surname' => $request->surname,
        'firstname' => $request->firstname,
        'middlename' => $request->middlename,
        'qualification' => $request->qualification,
        'gender' => $request->gender,
        'address' => $request->address,
        'email' => $request->email,
        'phone' => $request->phone,
        'session' => $request->session,
        'state_id' => $request->state_id,
        'lga_id' => $request->lga_id,
        'password' => $password,
        'next_of_kins' => $request->next_of_kins,
        'next_of_kins_address' => $request->next_of_kins_address,
        'next_of_kins_phone' => $request->next_of_kins_phone,
        'next_of_kins_email' => $request->next_of_kins_email,
        'health_status' => $request->health_status,
        'extra_curricular_activites' => $request->extra_curricular_activites,
        'health_status_desc' => $request->health_status_desc ,
        'marital_status' => $request->marital_status,
    ]);

    $teacher_update->subjects()->attach($request->subjects, ['school_id' => $request->school_id]);

    return response()->json([
        'data' => [
            'message' => 'Teacher Updated successfully'
        ]
    ]);




    }

    protected function permissionDeny($ability){
        Auth::shouldUse('ministry_api');
        return Gate::denies($ability);
    }
}
