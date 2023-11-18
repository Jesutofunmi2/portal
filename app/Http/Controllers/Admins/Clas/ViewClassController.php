<?php

namespace App\Http\Controllers\Admins\Clas;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClassResource;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use App\Repositories\Interfaces\ClassRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ViewClassController extends Controller
{
    /**
    * Class Repository class
    * @var obj
    */
    protected $clas;

    /**
    * Admin Repository class
    * @var obj
    */
    protected $admin;

    /**
    * Initialise Controller
    */
    public function __construct(AdminRepositoryInterface $admin, ClassRepositoryInterface $clas) {
        $this->middleware('auth:school_api');

        $this->admin = $admin;
        $this->clas = $clas;
    }

    /**
    * Retrieve all Student Houses from a School
    *
    * @param Request $request
    * @return Resource 
     */
     public function index(Request $request) {
        if($this->permissionDeny('view-class')){
            return response()->json([
                'message' => 'Permission Denied'
               ],403);
        }

        //Get the school admin id
        $admin_id = Auth::guard('school_api')->id();
        //Get the school_id
        $school_id = $this->admin->find($admin_id)->school_id;

        $query = $this->clas->setClass()->query();

        $classes = $query
        ->where('school_id', $school_id)
        ->when($request->query('query'), function ($q, $query) {
            return $q->where('class_name', 'like', '%'.$query.'%');
        })
        ->distinct()
        ->orderBy('class_name', 'asc')
        ->paginate(15);

        return ClassResource::collection($classes);
    }

    protected function permissionDeny($ability){
        Auth::shouldUse('school_api');
        return Gate::denies($ability);
    }
}
