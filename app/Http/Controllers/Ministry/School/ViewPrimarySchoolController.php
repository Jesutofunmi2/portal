<?php

namespace App\Http\Controllers\Ministry\School;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Gate;
use App\Models\PrimarySchool;
use App\Http\Resources\MinistrySchoolResource;

class ViewPrimarySchoolController extends Controller
{
    //
    protected $school;

    public function __construct() {

        $this->middleware('auth:ministry_api');

    }


    public function index(Request $request)
    {
        
        if($this->permissionDeny('view-school')){
            return response()->json([
                'message' => 'Permission Denied'
               ],403);
        }
        

        $this->validate($request,[
            'lga_id' => 'sometimes|integer',
            'query' => 'sometimes|string'
        ]);
        
        $query = PrimarySchool::query();

        $schools = $query
        ->when($request->query('lga_id'), function ($q, $lga_id) { 
            return $q->where('lga_id', $lga_id);})
        ->when($request->query('query'), function ($q, $query) { 
            return $q->where('name', 'like', '%'.$query.'%')->orWhere('address', 'like', '%'.$query.'%');
        })
        ->orderBy('id','desc')->paginate(20);

        return MinistrySchoolResource::collection($schools);

    }

    protected function permissionDeny($ability){
        Auth::shouldUse('ministry_api');
        return Gate::denies($ability);
    }
}
