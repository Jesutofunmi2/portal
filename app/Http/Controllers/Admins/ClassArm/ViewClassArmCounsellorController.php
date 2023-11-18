<?php

namespace App\Http\Controllers\Admins\ClassArm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ClassArmResource;
use App\Http\Resources\ClassArmCollection;
use App\Repositories\Interfaces\ClassArmRepositoryInterface;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use Auth;
use Gate;

class ViewClassArmCounsellorController extends Controller
{
    /**
    * ClassArm Repository class
    * @var obj
    */
    protected $classarm;

    /**
    * Admin Repository class
    * @var obj
    */
    protected $admin;

    /**
    * Initialise Controller
    */
    public function __construct(AdminRepositoryInterface $admin, ClassArmRepositoryInterface $classarm) {
        $this->middleware('auth:school_api');

        $this->admin = $admin;
        $this->classarm = $classarm;
    }

    /**
    * Fetch All Class Arm Counsellors in a given School
    *
    * @param Request $request
    * @return Resource
    */
    public function index(Request $request)
    {
        if($this->permissionDeny('assign-counsellor-to-classarm')){
            return response()->json([
                'message' => 'Permission Denied'
               ],403);
        }

        //Get the school admin id
        $admin_id = Auth::guard('school_api')->id();
        //Get the school_id
        $school_id = $this->admin->find($admin_id)->school_id;

        $query = $this->classarm->setClassArms()->query();

        $classarms = $query
        ->select('class_arms.id as id', 'class_arms.class_arm as class_arm', 'classes.class_name as class_name')
        ->where('class_arms.school_id', $school_id)
        ->leftJoin('classes', 'class_arms.class_id', '=', 'classes.id')
        ->when($request->query('query'), function ($q, $query) {
            return $q->where(function ($q) use ($query) { 
                $q->where('class_arms.class_arm', 'like', '%'.$query.'%')
                ->orWhere('classes.class_name', 'like', '%'.$query.'%');
            });
        })
        ->with(['counsellors' => function ($query) {
            $query->distinct()
            ->orderBy('surname', 'asc')
            ->orderBy('firstname', 'asc')
            ->orderBy('middlename', 'asc');
        }])
        ->orderBy('classes.class_name', 'asc')
        ->orderBy('class_arms.class_arm', 'asc')
        ->paginate(20)
        ->appends($request->query());
        
        return new ClassArmCollection($classarms);
    }

    protected function permissionDeny($ability){
        Auth::shouldUse('school_api');
        return Gate::denies($ability);
    }
}