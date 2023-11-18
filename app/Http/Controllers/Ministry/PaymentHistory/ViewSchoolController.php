<?php

namespace App\Http\Controllers\Ministry\PaymentHistory;

use App\Http\Controllers\Controller;
use App\Http\Resources\MinistryPaymentHistoryResource;
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
        if($this->permissionDeny('edit-id-card-request')){
            return response()->json([
                'message' => 'Permission Denied'
               ],403);
        }

        $this->validate($request,[
            'lga_id' => 'sometimes|integer',
            'query' => 'sometimes|string'
        ]);

        $query = $this->school->setSchool()->query();
        $school_table = $this->school->setSchool()->getTable();

        $user = Auth::guard('ministry_api')->user();

        $schools = $query->select($school_table.'.id', $school_table.'.name', $school_table.'.logo', $school_table.'.address',
                                    'lgas.name AS lga')
                        ->when($user && $user->is_aeozeo, function($q) use ($user) {
                            return $q->whereIn('lga_id', $user->lgas);
                        })
                        ->when($request->query('lga_id'), function ($q, $lga_id) { 
                            return $q->where('lga_id', $lga_id);})
                        ->when($request->query('query'), function ($q, $query) use ($school_table, $user){ 
                            if($user && $user->is_aeozeo) return $q->whereIn('lga_id', $user->lgas)->where($school_table.'.name', 'like', '%'.$query.'%');
                            return $q->where($school_table.'.name', 'like', '%'.$query.'%')->orWhere($school_table.'.address', 'like', '%'.$query.'%')->orWhere($school_table.'.principal_name', 'like', '%'.$query.'%');
                        })
                        ->leftJoin('lgas', 'lgas.id', '=', $school_table.'.lga_id')
                        ->paginate(40);

        return MinistryPaymentHistoryResource::collection($schools);
    }

    protected function permissionDeny($ability){
        Auth::shouldUse('ministry_api');
        return Gate::denies($ability);
    }
}
