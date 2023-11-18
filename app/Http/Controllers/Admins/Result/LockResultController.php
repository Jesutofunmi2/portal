<?php

namespace App\Http\Controllers\Admins\Result;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Resources\StudentResource;
use App\Http\Resources\StudentCollection;
use Illuminate\Support\Facades\DB;
use Auth;
use Gate;

class LockResultController extends Controller
{
    //
    protected $admin;

    protected $student;

    public function __construct(AdminRepositoryInterface $admin, StudentRepositoryInterface $student)
    {

        $this->middleware('auth:school_api');

        $this->admin = $admin;

        $this->student = $student;

    }

    public function updateLockRelease(Request $request)
    {
        if($this->permissionDeny('lock-and-release-student-result')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
        }

        $rules = [
            'student_id' => 'required|integer',
            'session' => 'required|integer',
            'term' => ['required','regex:/(First|Second|Third)/'],
            'class_id' => 'required|integer',
            'classarm_id' => 'required|integer',
            'type' => 'required|in:lock,release',
        ];

        $messages = [
            'student_id.required' => 'Please select a Student',
            'class_id.required' => 'Please select a Class',
            'classarm_id.required' => 'Please select a Class Arm',
            'type.required' => 'Please select either a Lock or a Release',
        ];
         
        $request->validate($rules, $messages);

        //Get the school admin id
        $admin_id = Auth::guard('school_api')->id();
        //Get the school_id
        $school_id = $this->admin->find($admin_id)->school_id;

        $student_id = $request->input('student_id');
        $class_id = $request->input('class_id');
        $classarm_id = $request->input('classarm_id');
        $session = $request->input('session');
        $term = $request->input('term');
        $type = $request->input('type');

        $status = $type == 'lock' ? 0 : 1;

        DB::table('student_results')
        ->where('class_id', $class_id)
        ->where('classarm_id', $classarm_id)
        ->where('session', $session)
        ->where('term', $term)
        ->where('student_id', $student_id)
        ->where('school_id', $school_id)
        ->update(['status' => $status]);

         return response()->json([
            'data' => [
                'message' => "Result successfully {$type}ed",
            ]
         ]);     
    }

    public function updateLockReleaseAll(Request $request)
    {
        if($this->permissionDeny('lock-and-release-student-result')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
        }

        $rules = [

            'session' => 'required|integer',
            'term' => ['required','regex:/(First|Second|Third)/'],
            'class_id' => 'required|integer',
            'classarm_id' => 'required|integer',
            'type' => 'required|in:lock,release',
        ];

        $messages = [
            'class_id.required' => 'Please select a Class',
            'classarm_id.required' => 'Please select a Class Arm',
            'type.required' => 'Please select either a Lock or a Release',
        ];
         
        $request->validate($rules, $messages);

        //Get the school admin id
        $admin_id = Auth::guard('school_api')->id();
        //Get the school_id
        $school_id = $this->admin->find($admin_id)->school_id;

        //Get the school admin id
        $admin_id = Auth::guard('school_api')->id();
        //Get the school_id
        $school_id = $this->admin->find($admin_id)->school_id;

        $class_id = $request->input('class_id');
        $classarm_id = $request->input('classarm_id');
        $session = $request->input('session');
        $term = $request->input('term');
        $type = $request->input('type');

        $status = $type == 'lock' ? 0 : 1;

        DB::table('student_results')
        ->where('class_id', $class_id)
        ->where('classarm_id', $classarm_id)
        ->where('session', $session)
        ->where('term', $term)
        ->where('school_id', $school_id)
        ->update(['status' => $status]);

         return response()->json([
            'data' => [
                'message' => "All Results successfully {$type}ed",
            ]
         ]);     
    }
    
    protected function permissionDeny($ability){
        Auth::shouldUse('school_api');
        return Gate::denies($ability);
    }
}