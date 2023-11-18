<?php

namespace App\Http\Controllers\Admins\ClassArm;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClassArmResource;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use App\Repositories\Interfaces\ClassArmRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class EditClassArmTeacherController extends Controller
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
        
        if($this->permissionDeny('edit-assign-teacher-to-classarm')){
           return response()->json([
            'message' => 'Permission Denied'
           ],403);
        }
        

        $classarm = $this->classarm->setClassArms()
        ->with(['classes', 'teachers' => function ($query) {
                $query->orderBy('surname', 'asc');
                $query->orderBy('firstname', 'asc');
                $query->orderBy('middlename', 'asc');
            }
        ])
        ->find($id);

        return response()->json([
            'data' => $classarm
        ]);

    }

    public function update(Request $request, $id = null)
    {
        $setClassArm = $this->classarm->find($id);

        if ($setClassArm) {

            //Get the school admin id
            $admin_id = Auth::guard('school_api')->id();
            //Get the school_id
            $school_id = $this->admin->find($admin_id)->school_id;
    
            $messages = [
                'teacher_id.required' => 'Select a Teacher.',
            ];
    
            $rules = [
                    'teacher_id' => 'required|int',
                    'session' => 'required|int',
            ];
        
            $this->validate($request, $rules, $messages);

            $session = $request->input('session');
            $teacher_id = $request->input('teacher_id');

            //Detach Previous Teacher
            $setClassArm->teachers()->detach();

            //Attach New Teacher
            $setClassArm->teachers()
            ->attach($teacher_id, ['session' => $session]);

            return response()->json([
                'data' => [
                    'message' => 'Class Arm Teacher updated successfully'
                ]
            ]);
        }

    }

    protected function permissionDeny($ability){
        Auth::shouldUse('school_api');
        return Gate::denies($ability);
    }
}
