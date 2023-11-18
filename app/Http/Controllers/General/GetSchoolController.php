<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\SchoolRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GetSchoolController extends Controller
{
    //
    protected $school;

    public function __construct(SchoolRepositoryInterface $school) {

        $this->school = $school;
    }

    public function index(Request $request)
    {
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
        ->orderBy('id','desc')->get(['id','name']);

        return response()->json([
            'data' => [
                'schools' => $schools,
            ]
        ]);

    }


}
