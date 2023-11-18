<?php

namespace App\Http\Controllers\Admins\Wallet;

use App\Models\ClasswalletTransaction;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClasswalletTransactionResource;
use App\Models\Classes;
use App\Models\Classwallet;
use App\Models\Student\Student;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClassWalletController extends Controller
{
    //
    protected $admin;

    protected $wallet;

    public function __construct(AdminRepositoryInterface $admin) 
    {
        $this->middleware('auth:school_api');

        $this->admin = $admin;
    }

    public function listClassWallet(Request $request)
    {
        $request->validate([
            'session' => 'required|integer'
        ]);
   
        $admin_id = Auth::guard('school_api')->id();
        //Get the school_id
        $school_id = $this->admin->find($admin_id)->school_id;
    
        $wallets = Classwallet::where([
            'school_id' => $school_id,
            'session' => $request->session])
            ->with('classes')->get();

        return $wallets;
    }

    public function createClassWallet(Request $request)
    {
       $request->validate([
            'class_id' => 'required|integer',
            'session' => 'required|integer'
       ]);

       $admin_id = Auth::guard('school_api')->id();
        //Get the school_id
        $school_id = $this->admin->find($admin_id)->school_id;

       $check = Classwallet::where([
                    'school_id' => $school_id,
                    'class_id' => $request->class_id,
                    'session' => $request->session
                ])->exists();

        if($check) {
            abort(400, 'Wallet already created for this class');
        }

       $wallet = Classwallet::create([
            'school_id' => $school_id,
            'class_id' => $request->class_id,
            'session' => $request->session
       ]);

       return $wallet;
    }

    public function addToWallet(Request $request)
    {
        $request->validate([
            'wallet_id' => 'required|integer',
            'amount' => 'required|integer|regex:/^\d*(\.\d{2})?$/',
            'session' => 'required|integer',
       ]);

        $admin_id = Auth::guard('school_api')->id();
    
        $admin = $this->admin->find($admin_id);
        $school_id = $admin->school_id;
        $admin_name = $admin->fullname;

        $schoolWallet = Wallet::where([
            'school_id' => $school_id,
            'session' => $request->session
        ])->first();      

        if (is_null($schoolWallet)) {
            abort(400, 'School wallet not found');
        }

        if ($request->amount > $schoolWallet->available_balance) {
            abort(400, 'Amount is greater than school wallet available balance');
        }

        $wallet = Classwallet::find($request->wallet_id);

       if(is_null($wallet)) {
           abort(400, 'class wallet not found');
       }

       DB::transaction(function() use (&$wallet, &$schoolWallet, $request, $school_id, $admin_name) {

            $schoolWallet->available_balance -= $request->amount;
            $schoolWallet->account_balance -= $request->amount;
            $schoolWallet->save();

            $wallet->available_balance += $request->amount;
            $wallet->last_amount = $request->amount;
            $wallet->save();

            $title = 'Credit Class Wallet';
            $amount = number_format($request->amount, 2);
            $total = number_format($wallet->available_balance, 2);
            $class_name = $this->getClassName($wallet->class_id);
            $msg = 'Wallet for '.$class_name.' was credited by '.$admin_name.'. Amount: NGN'.$amount.'. Total Balance: NGN'.$total;

            $this->addToHistory($title, $msg, $wallet->class_id, $school_id, $request->amount, $wallet->id);

            Transaction::create([
                'school_id' => $school_id,
                'wallet_id' => $schoolWallet->id,
                'title' => 'Digital Payment Deduction',
                'description' => 'A deduction of ₦'.number_format($request->amount, 2).' was made from your school wallet to '.$class_name.' wallet by '.$admin_name,
                'amount' => -$request->amount,
            ]);
       });

       return response()->json([
                        'message' => 'You have successfully added NGN'. number_format($request->amount, 2) .' to wallet'
                ]);
    }

    public function transactions(Request $request)
    {
        $request->validate([
            'wallet_id' => 'required|integer'
        ]);

        $wallet = Classwallet::find($request->wallet_id);

        $admin_id = Auth::guard('school_api')->id();
        //Get the school_id
        $school_id = $this->admin->find($admin_id)->school_id;

        $transactions = ClasswalletTransaction::where([
                            'wallet_id' => $request->wallet_id,
                            'school_id' => $school_id
                        ])->orderBy('id', 'desc')
                        ->paginate(40)
                        ->appends($request->query());

        $class_name = $wallet ? $this->getClassName($wallet->class_id) : 'Unknown';

        return ClasswalletTransactionResource::collection($transactions)->additional([
                                                            'class_name' => $class_name
                                                        ]);
    }

    protected function addToHistory($title, $msg, $class_id, $school_id, $amount, $wallet_id)
    {
        ClasswalletTransaction::create([
            'title' => $title,
            'class_id' => $class_id,
            'wallet_id' => $wallet_id,
            'amount' => $amount,
            'school_id' => $school_id,
            'message' => $msg
        ]);
    }

    protected function getClassName($class_id) 
    {
        $class = Classes::find($class_id);
        if ($class) {
            return $class->class_name;
        }

        return 'Unknown';
    }

    protected function getStudentName($student_id) 
    {
        $student = Student::where('regnum', $student_id)->first();
        if ($student) {
            return $student->fullname;
        }

        return 'Unknown';
    }
}
