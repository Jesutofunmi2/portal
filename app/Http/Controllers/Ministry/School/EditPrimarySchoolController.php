<?php

namespace App\Http\Controllers\Ministry\School;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Gate;
use App\Models\PrimarySchool;
use App\Http\Resources\MinistrySchoolResource;

class EditPrimarySchoolController extends Controller
{
    //
    protected $school;

    public function __construct() {

        $this->middleware('auth:ministry_api');

    }


    public function index(Request $request,$schoolID)
    {
       
        if($this->permissionDeny('edit-school')){
            return response()->json([
                'message' => 'Permission Denied'
               ],403);
        }

        $schools = PrimarySchool::findOrFail($schoolID);
        
        return new MinistrySchoolResource($schools);

    }

    public function update(Request $request)
    {
        if($this->permissionDeny('edit-school')){
            return response()->json([
                'message' => 'Permission Denied'
               ],403);
        }

        $this->validate($request, $this->rules());
           
        $setSchool = PrimarySchool::findOrFail($request->input('id'));
    
        $school = $setSchool->update([
            'name' => $request->input('school'),
            'lga_id' => $request->input('lga_id'),
            'address' => $request->input('address'),
        ]);

        return response()->json([
            'data' => [
                'message' => 'School updated successfully'
            ]
        ]);

    }

    protected function permissionDeny($ability){
        Auth::shouldUse('ministry_api');
        return Gate::denies($ability);
    }

    public function rules() : array
    {
        return [
            'school' => 'required|string|min:5|max:150',
            'lga_id' =>'required|integer',
            'address' => 'required|string|min:10'
        ];
    }
}
