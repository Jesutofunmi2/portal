<?php

namespace App\Http\Controllers\Ministry\School;

use App\Http\Controllers\Controller;
use App\Http\Resources\MinistrySchoolResource;
use App\Repositories\Interfaces\SchoolRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ViewSchoolController extends Controller
{
    //
    protected $school;

    public function __construct(SchoolRepositoryInterface $school) {

        $this->middleware('auth:ministry_api');

        $this->school = $school;

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

        $query = $this->school->setSchool()->query();

        $user = Auth::guard('ministry_api')->user();

        $schools = $query
        ->when($user && $user->is_aeozeo, function($q) use ($user) {
            return $q->whereIn('lga_id', $user->lgas);
        })
        ->when($request->query('lga_id'), function ($q, $lga_id) { 
            return $q->where('lga_id', $lga_id);
        })
        ->when($request->query('query'), function ($q, $query) use ($user) { 
            if($user && $user->is_aeozeo) return $q->whereIn('lga_id', $user->lgas)->where('name', 'like', '%'.$query.'%');
            return $q->where('name', 'like', '%'.$query.'%')->orWhere('address', 'like', '%'.$query.'%')->orWhere('principal_name', 'like', '%'.$query.'%');
        })
        ->orderBy('id','desc')->paginate(100);

        return MinistrySchoolResource::collection($schools);

    }

    public function all(Request $request)
    {
        
        if($this->permissionDeny('view-school')){
            return response()->json([
                'message' => 'Permission Denied'
               ],403);
        }

        $query = $this->school->setSchool()->query();

        $user = Auth::guard('ministry_api')->user();

        $schools = $query->
                    when($user && $user->is_aeozeo, function($q) use ($user) {
                        return $q->whereIn('lga_id', $user->lgas);
                    })->orderBy('id','desc')->get();

        return MinistrySchoolResource::collection($schools);

    }

    protected function permissionDeny($ability){
        Auth::shouldUse('ministry_api');
        return Gate::denies($ability);
    }
}
