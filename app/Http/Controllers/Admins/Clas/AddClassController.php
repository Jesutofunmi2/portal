<?php

namespace App\Http\Controllers\Admins\Clas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ClassResource;
use App\Repositories\Interfaces\ClassRepositoryInterface;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use Illuminate\Validation\Rule;
use Auth;
use Gate;

class AddClassController extends Controller
{
    //
    protected $clas;
    //
    protected $admin;

    public function __construct(ClassRepositoryInterface $clas, AdminRepositoryInterface $admin) {
        $this->clas = $clas;

        $this->admin = $admin;
    }

    /**
    * Add Class Arm
    * 
    * @param Request $request
    * @return Json
    */
    public function index(Request $request) {
        if($this->permissionDeny('create-class')){
            return response()->json([
                'message' => 'Permission Denied'
               ],403);
        }
        
        $setClass = $this->clas->setClass();
        //Get the school admin id
        $admin_id = Auth::guard('school_api')->id();
        //Get the school_id
        $school_id = $this->admin->find($admin_id)->school_id;
        
        $messages = [
            'class_name.required' => 'A Class name is required.',
            'class_name.unique' => 'This Class already exists.',
        ];

        $rules = [
                'class_name' => [ 'required', Rule::unique('classes')->where(function ($query) use ($school_id) {
                    return $query->where('school_id', $school_id);
                })
            ]
        ];

        $this->validate($request, $rules, $messages);
        
        $house = $setClass->create([
            'class_name' => $request->input('class_name'),
            'school_id' => $school_id,
        ]);

        return response()->json([
            'data' => [
                'message' => "Class added successfully"
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
