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

class EditSchoolHouseController extends Controller
{
    /**
    * @var obj
    */
    protected $house;

    /**
    * @var obj
    */
    protected $admin;

    public function __construct(StudentHouseRepositoryInterface $house, AdminRepositoryInterface $admin) {

        $this->middleware('auth:school_api');

        $this->house = $house;

        $this->admin = $admin;
    }

    /**
    * Retrieve Student House to be Edited
    *
    * @param Request $request
    * @param int $houseID
    * @return json Resource
    */
    public function index(Request $request, $houseID)
    {
        if($this->permissionDeny('edit-school-house')){
            return response()->json([
                'message' => 'Permission Denied'
               ],403);
        }

        $house = $this->house->find($houseID);
        
        return new StudentHouseResource($house);

    }

    /**
    * Update Student House
    *
    * @param Request $request
    * @return json
    */
    public function update(Request $request)
    {
        if($this->permissionDeny('edit-school-house')){
            return response()->json([
                'message' => 'Permission Denied'
               ],403);
        }

        //Get the school admin id
        $admin_id = Auth::guard('school_api')->id();
        //Get the school_id
        $school_id = $this->admin->find($admin_id)->school_id;

        $setHouse = $this->house->find($request->input('id'));

        $rule = ['name' => Rule::unique('student_houses')->where(function ($query) use ($school_id) {
            return $query->where('school_id', $school_id);
        })];
        $this->validate($request, $rule);
        
        $setHouse->name = $request->input('name');
        $setHouse->save();

        return response()->json([
            'data' => [
                'message' => 'School House updated successfully'
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
