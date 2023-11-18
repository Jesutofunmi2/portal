<?php

namespace App\Http\Controllers\Ministry\School;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PrimarySchool;
use Auth;
use Gate;

class CreatePrimarySchoolController extends Controller
{

    public function __construct() {

        $this->middleware('auth:ministry_api');

    }


    public function index(Request $request)
    {
        
        if($this->permissionDeny('create-school')){
           return response()->json([
            'message' => 'Permission Denied'
           ],403);
        }
        
        $school = new PrimarySchool;

        $this->validate($request, $this->rules());
       
        $school->create([
            'name' => $request->input('school'),
            'state_id' => env('STATE_ID'),
            'lga_id' => $request->input('lga_id'),
            'address' => $request->input('address'),
        ]);

        return response()->json([
            'data' => [
                'message' => 'School created successfully'
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
