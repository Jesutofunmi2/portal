<?php

namespace App\Http\Controllers\Admins\ClassArm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ClassArmResource;
use App\Repositories\Interfaces\ClassArmRepositoryInterface;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use Illuminate\Validation\Rule;
use Auth;
use Gate;

class AddClassArmController extends Controller
{
    //
    protected $classarm;
    //
    protected $admin;

    public function __construct(ClassArmRepositoryInterface $classarm, AdminRepositoryInterface $admin) {
        $this->classarm = $classarm;

        $this->admin = $admin;
    }

    /**
    * Add Class Arm
    * 
    * @param Request $request
    * @return Json
    */
    public function index(Request $request) {
        if($this->permissionDeny('create-classarm')){
            return response()->json([
                'message' => 'Permission Denied'
               ],403);
        }
        
        $setClassArms = $this->classarm->setClassArms();
        //Get the school admin id
        $admin_id = Auth::guard('school_api')->id();
        //Get the school_id
        $school_id = $this->admin->find($admin_id)->school_id;
        
        $messages = [
            'class_id.required' => 'The Class field is required.',
            'class_arm.required' => 'The Class Arm field is required.',
            'class_arm.unique' => 'This Class and Class Arm combination exists.',
        ];

        $rules = [
                'class_id' => 'required|integer',
                'class_arm' => [ 'required', Rule::unique('class_arms')->where(function ($query) use ($school_id, $request) {
                    return $query->where('school_id', $school_id)
                    ->where('class_id', $request->input('class_id'));
                })
            ]
        ];

        $this->validate($request, $rules, $messages);
        
        $house = $setClassArms->create([
            'class_arm' => $request->input('class_arm'),
            'class_id' => $request->input('class_id'),
            'school_id' => $school_id,
        ]);

        return response()->json([
            'data' => [
                'message' => "Class Arm added successfully"
            ]
        ]);
    }

    /**
    * Check for avility to perform action
    * 
    * @param string $ability
    * @return Gate
    */
    protected function permissionDeny($ability){
        Auth::shouldUse('school_api');
        return Gate::denies($ability);
    }
}
