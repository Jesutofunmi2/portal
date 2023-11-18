<?php

namespace App\Http\Controllers\Ministry\Wallet;

use App\Http\Controllers\Controller;
use App\Http\Resources\MinistryWalletResource;
use App\Models\PaymentItems;
use App\Models\Wallet;
use App\Repositories\Interfaces\SchoolRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ViewWalletController extends Controller
{
    //
    protected $school;

    public function __construct(SchoolRepositoryInterface $school) {

        $this->middleware('auth:ministry_api');

        $this->school = $school;
    }


    public function index(Request $request)
    {
        
        if($this->permissionDeny('edit-wallet')){
            return response()->json([
                'message' => 'Permission Denied'
               ],403);
        }

        $this->validate($request,[
            'lga_id' => 'sometimes|integer',
            'query' => 'sometimes|string',
            'session' => 'required|integer'
        ]);

        $this->updateWalletAccount();

        $query = $this->school->setSchool()->query();
        $school_table = $this->school->setSchool()->getTable();

        $schools = $query->select($school_table.'.id', $school_table.'.name', $school_table.'.lga_id',
                                    'wallets.available_balance', 'wallets.session'
                                 )
                                 ->selectRaw('wallets.id as wallet_id')
                                ->where('wallets.session', $request->session)
                                ->when($request->query('lga_id'), function ($q, $lga_id) { 
                                    return $q->where('lga_id', $lga_id);})
                                ->when($request->query('query'), function ($q, $query) { 
                                    return $q->where('name', 'like', '%'.$query.'%')->orWhere('address', 'like', '%'.$query.'%')->orWhere('principal_name', 'like', '%'.$query.'%');
                                })
                                ->join('wallets', 'wallets.school_id', '=', $school_table.'.id')
                                ->orderBy('id','desc')->paginate(20);

        $digital_fee = optional(PaymentItems::find(1))->cost;

        return MinistryWalletResource::collection($schools)->additional([
            'digital_fee' => $digital_fee 
        ]);
    }

    public function getWallets(Request $request)
    {
        if($this->permissionDeny('edit-wallet')){
            return response()->json([
                'message' => 'Permission Denied'
               ],403);
        }

        $this->validate($request,[
            'lga_id' => 'sometimes|integer',
            'query' => 'sometimes|string',
            'session' => 'required|integer'
        ]);

        $query = $this->school->setSchool()->query();

        $school_table = $this->school->setSchool()->getTable();
        $session = $request->session;

        $schools = $query->select($school_table.'.id', $school_table.'.name', $school_table.'.lga_id',
                                 'wallets.available_balance', 'wallets.session'
                                 )
                                 ->selectRaw('wallets.id as wallet_id')
                                ->when($request->query('lga_id'), function ($q, $lga_id) { 
                                    return $q->where('lga_id', $lga_id);})
                                ->when($request->query('query'), function ($q, $query) { 
                                    return $q->where('name', 'like', '%'.$query.'%')->orWhere('address', 'like', '%'.$query.'%')->orWhere('principal_name', 'like', '%'.$query.'%');
                                })
                                ->leftJoin('wallets', function($join) use ($session, $school_table) {
                                    $join->on('wallets.school_id', '=', $school_table.'.id')
                                    ->where('wallets.session', '=', $session);
                               })
                                ->orderBy('id','desc')->paginate(20);

        return MinistryWalletResource::collection($schools);
    }

    public function createWalletAccount(Request $request)
    {
        if($this->permissionDeny('edit-wallet')){
            return response()->json([
                'message' => 'Permission Denied'
               ],403);
        }

        $this->validate($request,[
            'session' => 'required|integer',
            'school_id' => 'required|integer'
        ]);

        $wallet = Wallet::where([
            'school_id' => $request->school_id,
            'session' => $request->session
        ])->first();

        if($wallet) {
            return response()->json([
                'data' => [
                    'status' => false,
                    'message' => "$request->session wallet already exist for this school"
                ]
            ]);
        }

        Wallet::create([
            'cleared_balance' => 0.00,
            'available_balance' => 0.00,
            'last_payment' => 0.00,
            'account_balance' => 0.00,
            'session' => $request->session,
            'school_id' => $request->school_id,
        ]);

        return response()->json([
            'data' => [
                'status' => true,
                'message' => "$request->session wallet created for this school"
            ]
        ]);
    }

    public function createAllWalletAccount(Request $request)
    {
        if($this->permissionDeny('edit-wallet')){
            return response()->json([
                'message' => 'Permission Denied'
               ],403);
        }

        $this->validate($request,[
            'session' => 'required|integer'
        ]);

        $query = $this->school->setSchool()->query();
        $school_table = $this->school->setSchool()->getTable();
        $session = $request->session;

        $schools = $query->select($school_table.'.id')
                                 ->selectRaw('wallets.id as wallet_id')
                                ->leftJoin('wallets', function($join) use ($session, $school_table) {
                                    $join->on('wallets.school_id', '=', $school_table.'.id')
                                    ->where('wallets.session', '=', $session);
                               })
                                ->get();

        if($schools->count() == 0) {
            return response()->json([
                'data' => [
                    'status' => false,
                    'message' => "No school found"
                ]
            ]);
        }

        $insert = [];

        $schools->each(function($school) use (&$insert, $session) {
            if(is_null($school->wallet_id)) {
                $insert[] = [
                    'cleared_balance' => 0.00,
                    'available_balance' => 0.00,
                    'last_payment' => 0.00,
                    'account_balance' => 0.00,
                    'session' => $session,
                    'school_id' => $school->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];
            }
        });

        $count = count($insert);
        if($count == 0) {
            return response()->json([
                'data' => [
                    'status' => false,
                    'message' => "$request->session wallet already exist for all schools"
                ]
            ]);
        }


        if($count > 0) {
            Wallet::insert($insert);
        }

        return response()->json([
            'data' => [
                'status' => true,
                'message' => "$request->session wallet created for $count schools"
            ]
        ]);
    }

    protected function permissionDeny($ability){
        Auth::shouldUse('ministry_api');
        return Gate::denies($ability);
    }

    protected function updateWalletAccount()
    {
        $wallets = Wallet::where('school_id', 0)->get();

        $wallets->each(function ($wallet) { 
            $school = $this->school->setSchool()->where('wallet_id', $wallet->id)->first();
            if($school) {
                $wallet->school_id = $school->id;
                $wallet->save();
            }
        });
    }
}
