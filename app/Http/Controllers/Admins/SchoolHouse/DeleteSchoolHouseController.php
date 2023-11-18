<?php

namespace App\Http\Controllers\Admins\SchoolHouse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Gate;
use App\Http\Resources\StudentHouseResource;
use App\Repositories\Interfaces\StudentHouseRepositoryInterface;

class DeleteSchoolHouseController extends Controller
{
    /**
    * @var obj
    */
    protected $house;

    public function __construct(StudentHouseRepositoryInterface $house) {

        $this->middleware('auth:school_api');
        
        $this->house = $house;
    }

    /**
    * Delete a Student House
    * 
    * @param int $id
    * @return Resource
    */
    public function index($id=null) {
        if($this->permissionDeny('delete-school-house')){
            return response()->json([
                'message' => 'Permission Denied'
               ],403);
        }

        $schoolHouse = $this->house->find($id);
        
        if ($schoolHouse->delete()) {

            return response()->json([
                'data' => [
                    'message' => 'School House Deleted successfully'
                ]
            ]);
        }
    }

    protected function permissionDeny($ability){
        Auth::shouldUse('school_api');
        return Gate::denies($ability);
    }
}
