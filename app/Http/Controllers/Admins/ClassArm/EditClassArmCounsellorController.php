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

class EditClassArmCounsellorController extends Controller
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
        
        if($this->permissionDeny('edit-assign-counsellor-to-classarm')){
           return response()->json([
            'message' => 'Permission Denied'
           ],403);
        }
        
        //$classarm = $this->classarm->find($id);
        $query = $this->classarm->setClassArms()->query();

        $classarm = $this->classarm->setClassArms()
        ->with(['classes', 'counsellors' => function ($query) {
                $query->distinct()
                ->orderBy('surname', 'asc')
                ->orderBy('firstname', 'asc')
                ->orderBy('middlename', 'asc');
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
                'teachers.required' => 'Select a Counsellor.',
            ];
    
            $rules = [
                    'teachers' => 'required',
                    'session' => 'required|int',
            ];
        
            $this->validate($request, $rules, $messages);

            $session = $request->input('session');
            $teachers = json_decode($request->input('teachers'));

            //Detach Previous Cousellors
            $setClassArm->counsellors()->detach();

            //Attach New Counsellors
            foreach ($teachers as $teach_id) {
                $setClassArm->counsellors()
                ->attach($teach_id, ['session' => $session]);
            }

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
