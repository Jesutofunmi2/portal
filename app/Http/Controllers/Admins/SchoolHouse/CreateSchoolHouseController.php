<?php

namespace App\Http\Controllers\Admins\SchoolHouse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\StudentHouseResource;
use App\Repositories\Interfaces\StudentHouseRepositoryInterface;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use Illuminate\Validation\Rule;
use Auth;
use Gate;

class CreateSchoolHouseController extends Controller
{
    //
    protected $house;
    //
    protected $admin;

    public function __construct(StudentHouseRepositoryInterface $house, AdminRepositoryInterface $admin) {
        $this->house = $house;

        $this->admin = $admin;
    }

    /**
    * Create Student House
    * 
    * @param Request $request
    * @return Json
    */
    public function index(Request $request) {
        if($this->permissionDeny('create-school-house')){
            return response()->json([
                'message' => 'Permission Denied'
               ],403);
        }
        
        $setSchoolHouse = $this->house->setSchoolHouse();
        //Get the school admin id
        $admin_id = Auth::guard('school_api')->id();
        //Get the school_id
        $school_id = $this->admin->find($admin_id)->school_id;
        
        $rule = ['name' => Rule::unique('student_houses')->where(function ($query) use ($school_id) {
            return $query->where('school_id', $school_id);
        })];

        $this->validate($request, $rule);
        
        $house = $setSchoolHouse->create([
            'name' => $request->input('name'),
            'school_id' => $school_id
        ]);

        return response()->json([
            'data' => [
                'message' => "School House, {$house->name} created successfully"
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
