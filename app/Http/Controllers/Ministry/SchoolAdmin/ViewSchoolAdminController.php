<?php

namespace App\Http\Controllers\Ministry\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\General\HelperController;
use App\Http\Resources\MinistrySchoolAdminResource;
use App\Models\NgStates;
use App\Models\NgStatesLGA;
use App\Models\School;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use PDF;

class ViewSchoolAdminController extends Controller
{
    //
    protected $admin;

    public function __construct(AdminRepositoryInterface $admin)
        {

        $this->middleware('auth:ministry_api');

        $this->admin = $admin;

    }


    public function index(Request $request)
    {
        
        if($this->permissionDeny('view-school-admin')){
           return response()->json([
            'message' => 'Permission Denied'
           ],403);
        }

        $user = Auth::guard('ministry_api')->user();

        $school_ids = [];

        if($user && $user->is_aeozeo) {
            $school_ids = HelperController::aeozeoSchoolsId($user->lgas);
        }
        
        $query = $this->admin->setAdmin()->query()
        ->when($user && $user->is_aeozeo, function($q) use ($school_ids) {
            return $q->whereIn('school_id', $school_ids);
        })
        ->when($request->query('school_id'), function ($q, $school_id) { 
            return $q->where('school_id', $school_id);})
        ->when($request->query('query'), function ($q, $query) use ($user, $school_ids) {
            if($user && $user->is_aeozeo) return $q->whereIn('school_id', $school_ids)->where('fullname', 'like', '%'.$query.'%');
            return $q->where('fullname', 'like', '%'.$query.'%')->orWhere('username', 'like', '%'.$query.'%')->orWhere('email', 'like', '%'.$query.'%');
        })
        ->orderBy('id','desc')->paginate(40);

        return MinistrySchoolAdminResource::collection($query);

    }

    public function print(Request $request)
    {   
        if($this->permissionDeny('view-school-admin')) {
           return response()->json([
            'message' => 'Permission Denied'
           ],403);
        }

        $request->validate([
            'lga_id' => 'required|integer',
            'type' => 'required|string'
        ]);

        $aeozeo = School::aeozeoAdmin($request->lga_id);
        $aeozeoData = $aeozeo->map(function($admin) {
            return  [
                'name' => $admin->fullname,
                'phone' => $admin->phone
            ];
        });

        $schools = School::where('lga_id', $request->lga_id)->with('schoolAdmin')->get();

        $data = $schools->map(function ($school) {
           $admins = $school->schoolAdmin->map(function ($admin) {
                return  [
                    'name' => $admin->fullname,
                    'phone' => $admin->phone
                ];
           });

           return [
                'school_name' => $school->name,
                'address' => $school->address,
                'phone' => $school->phone,
                'principal_name' => $school->principal_name,
                'admins' => $admins,
           ];

        });

        if($request->type == 'print') {
            $lga = NgStatesLGA::find($request->lga_id);

            $pdf = PDF::loadView('ministry.pdf.school_admins', 
                    [
                        'schools' => $data,
                        'aeozeos' => $aeozeoData, 
                        'lga' => $lga,
                    ])
                ->setPaper('a4', 'landscape');

            $filename = 'generatedPdf/'.str_replace([ ' ', '/'], '-', $lga->name).'school_admins.pdf';

            $pdf->save($filename);
            $url = env('BASE_PATH').$filename;

            return [
                'schools' =>  $data,
                'aeozeos' => $aeozeoData,
                'url' => $url
            ];
       }

        return [
           'schools' =>  $data,
           'aeozeos' => $aeozeoData,
           'url' => null
       ];
    }

    protected function permissionDeny($ability){
        Auth::shouldUse('ministry_api');
        return Gate::denies($ability);
    }
}
