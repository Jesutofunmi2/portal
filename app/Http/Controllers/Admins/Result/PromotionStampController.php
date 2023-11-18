<?php

namespace App\Http\Controllers\Admins\Result;

use App\Http\Controllers\Controller;
use App\Http\Resources\StudentCollection;
use App\Http\Resources\StudentResource;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class PromotionStampController extends Controller
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

    public function updatePromotionStamp(Request $request)
    {
        if($this->permissionDeny('lock-and-release-student-result')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
        }

        $rules = [
            'student_id' => 'required|integer',
            'session' => 'required|integer',
            'term' => 'required|in:Third',
            'class_id' => 'required|integer',
            'classarm_id' => 'required|integer',
            'type' => 'required|in:promoted,repeat,withdraw,promoted_on_trial',
        ];

        $messages = [
            'student_id.required' => 'Please select a Student',
            'class_id.required' => 'Please select a Class',
            'classarm_id.required' => 'Please select a Class Arm',
            'type.required' => 'Please select a Promotion Stamp',
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

        $promotion = 1;
        if ($type == 'promoted') {
            $promotion = 2;
        } elseif ($type == 'repeat') {
            $promotion = 3;
        } elseif ($type == 'withdraw') {
            $promotion = 4;
        } elseif ($type == 'promoted_on_trial') {
            $promotion = 5;
        }

        DB::table('student_results')
        ->where('class_id', $class_id)
        ->where('classarm_id', $classarm_id)
        ->where('session', $session)
        ->where('term', $term)
        ->where('student_id', $student_id)
        ->where('school_id', $school_id)
        ->update(['promotion' => $promotion]);

         return response()->json([
            'data' => [
                'message' => "Result successfully stamped with {$type}",
            ]
         ]);        
    }

    public function updatePromotionStampAll(Request $request)
    {
        if($this->permissionDeny('lock-and-release-student-result')){
            return response()->json([
             'message' => 'Permission Denied'
            ],403);
        }

        $rules = [

            'session' => 'required|integer',
            'term' => 'required|in:Third',
            'class_id' => 'required|integer',
            'classarm_id' => 'required|integer',
            'type' => 'required|in:promoted,repeat,withdraw,promoted_on_trial',
        ];

        $messages = [
            'class_id.required' => 'Please select a Class',
            'classarm_id.required' => 'Please select a Class Arm',
            'type.required' => 'Please select a Promotion Stamp',
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

        $promotion = 1;
        if ($type == 'promoted') {
            $promotion = 2;
        } elseif ($type == 'repeat') {
            $promotion = 3;
        } elseif ($type == 'withdraw') {
            $promotion = 4;
        } elseif ($type == 'promoted_on_trial') {
            $promotion = 5;
        }

        DB::table('student_results')
        ->where('class_id', $class_id)
        ->where('classarm_id', $classarm_id)
        ->where('session', $session)
        ->where('term', $term)
        ->where('school_id', $school_id)
        ->update(['promotion' => $promotion]);

         return response()->json([
            'data' => [
                'message' => "All Results successfully stamped with {$type}",
            ]
         ]);     
    }
    
    protected function permissionDeny($ability){
        Auth::shouldUse('school_api');
        return Gate::denies($ability);
    }
}