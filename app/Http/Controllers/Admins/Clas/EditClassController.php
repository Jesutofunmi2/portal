<?php

namespace App\Http\Controllers\Admins\Clas;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\ClassRepositoryInterface;
use App\Http\Resources\ClassResource;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use Auth;
use Gate;

class EditClassController extends Controller
{
    //
    protected $clas;

    protected $admin;

    public function __construct(ClassRepositoryInterface $clas, AdminRepositoryInterface $admin)
    {

        $this->middleware('auth:school_api');

        $this->clas = $clas;

        $this->admin = $admin;

    }


    public function index($id = null)
    {
        
        if($this->permissionDeny('edit-class')){
           return response()->json([
            'message' => 'Permission Denied'
           ],403);
        }
        
        $clas = $this->clas->find($id);

        return new ClassResource($clas);

    }

    public function update(Request $request, $id = null)
    {
        $setClass = $this->clas->find($id);

        if($setClass){

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

            $clas = $setClass->update([
                'class_name' => $request->input('class_name'),
            ]);

            return response()->json([
                'data' => [
                    'message' => 'Class updated successfully'
                ]
            ]);
        }

    }

    protected function permissionDeny($ability){
        Auth::shouldUse('school_api');
        return Gate::denies($ability);
    }
}
