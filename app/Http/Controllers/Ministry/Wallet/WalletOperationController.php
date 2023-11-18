<?php

namespace App\Http\Controllers\Ministry\Wallet;

use App\Http\Controllers\Controller;
use App\Http\Resources\WalletCollection;
use App\Models\PaymentItems;
use App\Models\School;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class WalletOperationController extends Controller
{
    public function __construct() 
    {
        $this->middleware('auth:ministry_api');
    }


    public function add(Request $request): JsonResponse
    {
        if($this->permissionDeny('edit-wallet')) {
            return response()->json([
                'message' => 'Permission Denied'
               ],403);
        }

        $this->validate($request,[
            'wallet_id' => 'required|integer',
            'school_id' => 'required|integer',
            'amount' => ['required', 'regex:/^\d*(\.\d{2})?$/']
        ]);  

        DB::transaction(function() use ($request) {
            $wallet = Wallet::findOrFail($request->wallet_id);
            $wallet->available_balance += $request->amount;
            $wallet->account_balance += $request->amount;
            $wallet->last_payment = $request->amount;
            $wallet->save();

            Transaction::create([
                'school_id' => $request->school_id,
                'wallet_id' => $request->wallet_id,
                'title' => 'Digital payment Added',
                'description' => 'Your wallet was credited with ₦'.number_format($request->amount, 2).' by Ministry',
                'amount' => $request->amount,
            ]);
        });
        

        return response()->json([
            'message' => "You have Successfully Added ₦".number_format($request->amount) ." to wallet"
        ]);
    }

    public function deduct(Request $request): JsonResponse
    {
        if($this->permissionDeny('edit-wallet')) {
            return response()->json([
                'message' => 'Permission Denied'
               ],403);
        }

        $this->validate($request,[
            'wallet_id' => 'required|integer',
            'school_id' => 'required|integer',
            'amount' => ['required', 'regex:/^\d*(\.\d{2})?$/']
        ]);  

        $wallet = Wallet::findOrFail($request->wallet_id);

        if ($request->amount > $wallet->available_balance) abort(422, 'Amount is greater than balance');

        DB::transaction(function() use (&$wallet, $request) {
            $wallet->available_balance -= $request->amount;
            $wallet->account_balance -= $request->amount;
            $wallet->save();

            Transaction::create([
                'school_id' => $request->school_id,
                'wallet_id' => $request->wallet_id,
                'title' => 'Digital Payment Deduction',
                'description' => 'A deduction of ₦'.number_format($request->amount, 2).' was made from your wallet by Ministry',
                'amount' => -$request->amount,
            ]);
        });

        return response()->json([
            'message' => "You have Successfully Deducted ₦".number_format($request->amount) ." from wallet"
        ]);
    }

    public function reset(Request $request): JsonResponse
    {
        if($this->permissionDeny('edit-wallet')) {
            return response()->json([
                'message' => 'Permission Denied'
               ],403);
        }

        $this->validate($request,[
            'wallet_id' => 'required|integer',
            'school_id' => 'required|integer',
        ]); 

        DB::transaction(function() use ($request) {
            $wallet = Wallet::findOrFail($request->wallet_id);
            $balance = number_format($wallet->available_balance,2);
            $wallet->available_balance = 0;
            $wallet->account_balance = 0;
            $wallet->last_payment = 0;
            $wallet->save();

            Transaction::create([
                'school_id' => $request->school_id,
                'wallet_id' => $request->wallet_id,
                'title' => 'Digital payment Reset',
                'description' => "Your wallet was reset from ₦$balance to ₦0.0 by Ministry",
                'amount' => 0,
            ]);
        });

        return response()->json([
            'message' => "You have Successfully Reset Wallet"
        ]);
    }

    public function transaction(Request $request): JsonResponse
    {
        if($this->permissionDeny('edit-wallet')) {
            return response()->json([
                'message' => 'Permission Denied'
               ],403);
        }

        $this->validate($request,[
            'school_id' => 'required|integer',
        ]); 

        $school = School::findOrFail($request->school_id, ['name', 'logo']);
        $wallets = Transaction::whereSchoolId($request->school_id)->orderBy('id', 'desc')->get();

        $wallet_list = $wallets->map(function($wallet) {
            return [
                'title' => $wallet->title,
                'time' => $wallet->created_at,
                'description' => $wallet->description,
            ];
        });

        return response()->json([
            'data' => [
                'school_name' => $school->name,
                'school_logo' => $school->logo,
                'wallet_list' => $wallet_list
            ]
        ]);
    }

    public function analysis(Request $request): JsonResponse
    {
        if($this->permissionDeny('edit-wallet')) {
            return response()->json([
                'message' => 'Permission Denied'
               ],403);
        }
        
        $this->validate($request,[
            'school_id' => 'required|integer',
            'session' => ['sometimes', 'integer']
        ]);

        $school = School::findOrFail($request->school_id, ['name']);

        $wallets = Transaction::query()->whereSchoolId($request->school_id)
                        ->when(
                                $request->session, function($query, $session) {
                                return $query->whereYear('created_at', $session);
                        })->get();
        $total = 0;

        $wallets = $wallets->map( function ($wallet) use (&$total) {
            if(is_numeric($wallet->amount)) $total += $wallet->amount;
            
            return [
                'title' => $wallet->title,
                'amount' => $wallet->amount,
                'total_amount' => $total,
                'created_at' => $wallet->created_at,
                'description' => $wallet->description,
            ];
        });

        $digital_fee = optional(PaymentItems::find(1))->cost ?? 0;

        return response()->json([
            'data' => [
                'school_name' => $school->name,
                'analysis' => $wallets,
                'digital_fee' => $digital_fee,
            ]
        ]);

    }

    public function setDigitalFee(Request $request): JsonResponse
    {
        if($this->permissionDeny('edit-wallet')) {
            return response()->json([
                'message' => 'Permission Denied'
               ],403);
        }

        $this->validate($request,[
            'amount' => 'required|integer',
        ]);

        PaymentItems::find(1)->update([
            'cost' => $request->amount
        ]);

        return response()->json([
            'message' => "Digital payment fee has been set to ₦".number_format($request->amount)
        ]);
    }

    protected function permissionDeny($ability){
        Auth::shouldUse('ministry_api');
        return Gate::denies($ability);
    }

}
