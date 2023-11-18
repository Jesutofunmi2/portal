<?php

namespace App\Http\Controllers\Admins\SchoolHouse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\StudentHouseResource;
use App\Repositories\Interfaces\StudentHouseRepositoryInterface;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use Auth;
use Gate;

class ViewSchoolHouseController extends Controller
{
    /**
    * Studenthouse Repository class
    * @var obj
    */
    protected $house;

    /**
    * Admin Repository class
    * @var obj
    */
    protected $admin;

    /**
    * Initialise Controller
    */
    public function __construct(AdminRepositoryInterface $admin, StudentHouseRepositoryInterface $house) {
        $this->middleware('auth:school_api');

        $this->admin = $admin;
        $this->house = $house;
    }

    /**
    * Retrieve all Student Houses from a School
    *
    * @param Request $request
    * @return Resource 
     */
     public function index(Request $request) {
        if($this->permissionDeny('view-school-house')){
            return response()->json([
                'message' => 'Permission Denied'
               ],403);
        }

        //Get the school admin id
        $admin_id = Auth::guard('school_api')->id();
        //Get the school_id
        $school_id = $this->admin->find($admin_id)->school_id;

        $query = $this->house->setSchoolHouse()->query();

        $houses = $query
        ->where('school_id', $school_id)
        ->orderBy('name', 'asc')
        ->paginate(15);

        return StudentHouseResource::collection($houses);
    }

    protected function permissionDeny($ability){
        Auth::shouldUse('school_api');
        return Gate::denies($ability);
    }
}
