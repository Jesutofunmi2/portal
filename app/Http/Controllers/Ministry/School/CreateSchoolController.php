<?php

namespace App\Http\Controllers\Ministry\School;

use App\Http\Controllers\Controller;
use App\Http\Helper\ImageUploader;
use App\Models\Wallet;
use App\Repositories\Interfaces\SchoolRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class CreateSchoolController extends Controller
{
    //
    protected $school;

    public function __construct(SchoolRepositoryInterface $school) {

        $this->middleware('auth:ministry_api');

        $this->school = $school;
    }


    public function index(Request $request)
    {
        if($this->permissionDeny('create-school')){
           return response()->json([
            'message' => 'Permission Denied'
           ],403);
        }
        
        $setSchool = $this->school->setSchool();

        $this->validate($request, $setSchool::$rules);
        if ($request->hasFile('logo'))
        {
            $url = ImageUploader::saveImage($request,'images/school_logos');
        }
        else {
            $url = '';
        }
        
        $session = date('Y');
         
        DB::transaction(function() use ($request, $setSchool, $url, $session) {
            $school = $setSchool->create([
                'name' => $request->input('school'),
                'state_id' => env('STATE_ID'),
                'lga_id' => $request->input('lga_id'),
                'school_category' => $request->input('school_category'),
                'address' => $request->input('address'),
                'logo' => $url,
            ]);
    
            $wallet = Wallet::create([
                'cleared_balance' => 0.00,
                'available_balance' => 0.00,
                'last_payment' => 0.00,
                'account_balance' => 0.00,
                'session' => $session - 1,
                'school_id' => $school->id,
            ]);
             // we add same school to second database, our old app make use of this database 
            $lga_id = $request->input('lga_id') > 579 ? $request->input('lga_id') - 569 : $request->input('lga_id') - 568;
            DB::table('schools_new')->insert([
                'name' => $request->input('school'),
                'state_id' => $request->input('state_id'),
                'lga_id' => $lga_id,
                'school_category' => $request->input('school_category'),
                'address' => $request->input('address'),
                'wallet_id' => $wallet->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        });

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
}
