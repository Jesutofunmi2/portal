<?php

namespace App\Http\Controllers\Admins\School;

use App\Http\Controllers\Controller;
use App\Http\Resources\MinistrySchoolResource;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use App\Repositories\Interfaces\SchoolRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ViewSchoolController extends Controller
{
    /**
    * School Repository class
    * @var obj
    */
    protected $school;

    /**
    * Admin Repository class
    * @var obj
    */
    protected $admin;

    /**
    * Initialise Controller
    */
    public function __construct(AdminRepositoryInterface $admin, SchoolRepositoryInterface $school) {
        $this->middleware('auth:school_api');

        $this->admin = $admin;
        $this->school = $school;
    }

    /**
    * Retrieve all Schools From an LGA
    *
    * @param Int $lga_id
    * @return Resource 
     */
     public function index($lga_id) {
        $query = $this->school->setSchool()->query();

        $schools = $query
        ->where('lga_id', $lga_id)
        ->orderBy('name', 'asc')
        ->get();

        return MinistrySchoolResource::collection($schools);
    }

    protected function permissionDeny($ability){
        Auth::shouldUse('school_api');
        return Gate::denies($ability);
    }
}
