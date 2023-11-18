<?php

namespace App\Http\Controllers\Admins\ClassArm;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\ClassArmRepositoryInterface;
use App\Http\Resources\ClassArmResource;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use Auth;
use Gate;

class EditClassArmController extends Controller
{
    //
    protected $classarm;

    protected $admin;

    public function __construct(ClassArmRepositoryInterface $classarm, AdminRepositoryInterface $admin)
        {

        $this->middleware('auth:school_api');

        $this->classarm = $classarm;

        $this->admin = $admin;

    }


    public function index($id = null)
    {
        
        if($this->permissionDeny('edit-classarm')){
           return response()->json([
            'message' => 'Permission Denied'
           ],403);
        }
        
        $classarm = $this->classarm->find($id);

        return new ClassArmResource($classarm);

    }

    public function update(Request $request, $id = null)
    {
        $setClassArm = $this->classarm->find($id);

        if($setClassArm){

            //Get the school admin id
            $admin_id = Auth::guard('school_api')->id();
            //Get the school_id
            $school_id = $this->admin->find($admin_id)->school_id;
            //Get the class_id
            $class_id = $setClassArm->class_id;
    
            $messages = [
                'class_arm.required' => 'The Class Arm field is required.',
                'class_arm.unique' => 'This Class and Class Arm combination exists.',
            ];
    
            $rules = [
                    'class_arm' => [ 'required', Rule::unique('class_arms')->where(function ($query) use ($school_id, $class_id) {
                        return $query->where('school_id', $school_id)
                        ->where('class_id', $class_id);
                    })
                ]
            ];
        
            $this->validate($request, $rules, $messages);

            $classarm = $setClassArm->update([
                'class_arm' => $request->input('class_arm'),
            ]);

            return response()->json([
                'data' => [
                    'message' => 'Class Arm updated successfully'
                ]
            ]);
        }

    }

    protected function permissionDeny($ability){
        Auth::shouldUse('school_api');
        return Gate::denies($ability);
    }
}
