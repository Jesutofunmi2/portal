<?php

namespace App\Http\Controllers\Admins\Wallet;

use App\Http\Controllers\Controller;
use App\Models\Classwallet;
use App\Models\ClasswalletTransaction;
use App\Models\DigitalPayment;
use App\Models\ResultVoucher;
use App\Models\School;
use App\Models\Student\Student;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use App\Repositories\Interfaces\ClassArmRepositoryInterface;
use App\Repositories\Interfaces\ResultVoucherRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VerifyPaymentController extends Controller
{
    public $result_vouchers;
    public $class_arms;
    public $admin;

    public function __construct(ResultVoucherRepositoryInterface $result_vouchers,
                                ClassArmRepositoryInterface $class_arms,
                                AdminRepositoryInterface $admin
                            ) 
    {
        $this->result_vouchers = $result_vouchers;
        $this->class_arms = $class_arms;
        $this->admin = $admin;
    }

    public function index(Request $request) {
        $request->validate([
            'student_id' => 'required|integer',
            'class_id' => 'required|integer',
            'session' => 'required|integer',
        ]);

	    $admin_id = Auth::guard('school_api')->id();
        //Get the school_id
        $admin = $this->admin->find($admin_id);
        $school_id = $admin->school_id;

		$wallet = Classwallet::where([
            'school_id' => $school_id,
            'class_id' => $request->class_id,
            'session' => $request->session
         ])->first();
        
         $session_next = $request->session +1;

        if(is_null($wallet)) {
            abort(400, "class wallet not found for $request->session/$session_next");
        }

	    $amount = DB::table('payment_items')->first()->cost;

	    $balance = $wallet->available_balance;
	    
        $student =  Student::find($request->student_id);

        $student_class = DB::table('classarm_student')
                            ->where('student_id', $student->id)
                            ->where('session', $request->session)
                            ->first();

        if(is_null($student_class)) {
            abort(400, "student not found on $request->session/$session_next session");
        }
        // $student_current_class = DB::table('classarm_student')
        //                     ->where('student_id', $student->id)
        //                     ->orderBy('session', 'desc')
        //                     ->first();

        if($balance >= $amount) {
            $payment = DigitalPayment::where([
                        'student_id' => $student->id,
                        'session' => $request->session
                        ])
                        ->first();

            if($payment){
                $payment->is_verified = true;
                $payment->save();
   
                abort(400, 'Opps...'.$student->firstname.' was verified '.$payment->created_at->diffForHumans());
            }else{
                // make scratch card
                $result_vouchers = $this->result_vouchers->setResultVoucher();
               
                list($pin1, $pin2, $pin3, $pin4) = $this->getRandomVoucher(1);
                $pin = $pin1 . $pin2 . $pin3 . $pin4;
                $serial = $this->getSerialNumber();
                
                $result_vouchers->pin1 = $pin1;
                $result_vouchers->pin2 = $pin2;
                $result_vouchers->pin3 = $pin3;
                $result_vouchers->pin4 = $pin4;
                $result_vouchers->pin = $pin;
                $result_vouchers->serial = $serial;
                $result_vouchers->student_id = $student->id;
                $result_vouchers->classarm_id = $student_class->classarm_id;
                $result_vouchers->class_id = $student_class->class_id;
                $result_vouchers->session = $student_class->session;
                $result_vouchers->term = 'First';
                $result_vouchers->save();
                
                $wallet->available_balance -= $amount;
                $wallet->save();
                
                DigitalPayment::create([
                    'student_id' => $student->id,
                    'is_verified' => true,
                    'session' => $student_class->session
                ]);

                ClasswalletTransaction::create([
                    'title' => 'Debit Class Wallet',
                    'class_id' => $student_class->class_id,
                    'wallet_id' => $wallet->id,
                    'amount' => -$amount,
                    'school_id' => $school_id,
                    'message' => $request->session .'/'.$session_next .' session digital payment of NGN'.number_format($amount, 2).' was made on this wallet for '.$student->surname.' '.$student->firstname.' '.$student->middlename.' ('.$student->regnum.') by '. $admin->fullname
                ]);
                
                return response()->json([
                    'data' => ['message' => 'Payment for '.$student->firstname.' was successfull']
                ]);
            }
        }else {
            abort(400, 'Payment for '.$student->firstname.' was not successfull. Insufficient balance');
        }
    
	}

    public function bulkVerifyPayment(Request $request) {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|min:1',
            'class_id' => 'required|integer',
            'session' => 'required|integer',
        ]);

	    $admin_id = Auth::guard('school_api')->id();
        //Get the school_id
        $admin = $this->admin->find($admin_id);
        $school_id = $admin->school_id;

		$wallet = Classwallet::where([
            'school_id' => $school_id,
            'class_id' => $request->class_id,
            'session' => $request->session
         ])->first();
            
        $session_next = $request->session +1;
        if(is_null($wallet)) {
            abort(400, "class wallet not found for $request->session/$session_next");
        }

	    $amount = DB::table('payment_items')->first()->cost;

	    $balance = $wallet->available_balance;
        $wallet_id = $wallet->id;

        $total_student = count($request->ids);

        if($total_student * $amount > $balance) {
            abort(400, 'Sorry, Available balance can not pay for '.$total_student.' students');
        }
	    
        $students =  Student::whereIn('id', $request->ids)->get();
        $error = [];
        $success = [];
        $digital_payment = [];
        $digital_transaction = [];
        $voucher = array();
        $total = 0;
        $session = $request->session;

        $students->each(function(Student $student) use (&$balance, &$digital_payment, 
                                &$digital_transaction, $amount, $session, $session_next,
                                &$total, &$success, $school_id, $wallet_id,
                                $admin, &$error, &$voucher) {

            $student_class = DB::table('classarm_student')
                            ->where('student_id', $student->id)
                            ->where('session', $session)
                            ->first();

            if($balance >= $amount) {
                $payment = DigitalPayment::where([
                            'student_id' => $student->id,
                            'session' => $student_class->session
                            ])
                            ->first();

                if($payment) {
                    $payment->is_verified = true;
                    $payment->save();
                    
                    $error[] = 'Opps...'.$student->firstname.' was verified '.$payment->created_at->diffForHumans();
                }
                else {
                    // make scratch card
                    list($pin1, $pin2, $pin3, $pin4) = $this->getRandomVoucher(1);
                    $pin = $pin1 . $pin2 . $pin3 . $pin4;
                    $serial = $this->getSerialNumber();

                    $voucher[] = array(
                        'pin1' => $pin1,
                        'pin2' => $pin2,
                        'pin3' => $pin3,
                        'pin4' => $pin4,
                        'pin' => $pin,
                        'serial' => $serial,
                        'student_id' => $student->id,
                        'classarm_id' => $student_class->classarm_id,
                        'class_id' => $student_class->class_id,
                        'session' => $student_class->session,
                        'term' => 'First',
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    );

                    $balance -= $amount;
                    $total += $amount;
                    
                    $digital_payment[] = array(
                        'student_id' => $student->id,
                        'is_verified' => true,
                        'session' => $student_class->session,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    );

                    $digital_transaction[] = array(
                    'title' => 'Debit Class Wallet',
                    'class_id' => $student_class->class_id,
                    'wallet_id' => $wallet_id,
                    'amount' => -$amount,
                    'school_id' => $school_id,
                    'message' => $session .'/'.$session_next .' session digital payment of NGN'.number_format($amount, 2).' was made on this wallet for '.$student->surname.' '.$student->firstname.' '.$student->middlename.' ('.$student->regnum.') by '. $admin->fullname,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    );
                    
                    $success[] = 'Payment for '.$student->firstname.' was successfull';
                }
            }else {
                $error[] = 'Payment for '.$student->firstname.' was not successfull. Insufficient balance';
            }
        });

        if(count($success) || count($digital_payment)) {
            $wallet->available_balance -= $total;
            $wallet->save();
    
            $result_voucher = $this->result_vouchers->setResultVoucher();
            $result_voucher->insert($voucher);
    
            DigitalPayment::insert($digital_payment);
            ClasswalletTransaction::insert($digital_transaction);
        }
        
        return response()->json([
            'data' => [
                'success' => $success,
                'error' => $error
            ]
        ]);
	}

    public function students(Request $request)
    {
       $request->validate([
        'class_id' => 'required|integer',
        'session' => 'required|integer',
        'class_arm_id' => 'required|integer',
       ]);

       $class_arm_id = $this->class_arms->find($request->input('class_arm_id'));

       $session = $request->session;

        $students = $class_arm_id->students()
                                    ->select('students.id', 'students.surname', 'students.firstname', 
                                    'students.regnum', 'digital_payments.is_verified',
                                    'students.passport'
                                    )
                                    ->wherePivot('session', $request->session)
                                    ->wherePivot('class_id', $request->class_id)
                                    ->groupBy('students.id')
                                    ->leftJoin('digital_payments', function($join) use ($session) {
                                        $join->on('students.id', '=', 'digital_payments.student_id')
                                        ->where('digital_payments.session', '=', $session);
                                   })
                                    ->get();
       return response()->json([
           'data' => $students
       ]);
    }

    public function wallet(Request $request)
    {
        $request->validate([
            'class_id' => 'required|integer',
            'session' => 'required|integer',
        ]);

        $admin_id = Auth::guard('school_api')->id();
        //Get the school_id
        $admin = $this->admin->find($admin_id);
        $school_id = $admin->school_id;

        $wallet = Classwallet::where([
            'school_id' => $school_id,
            'class_id' => $request->class_id,
            'session' => $request->session
         ])->first();
         $session_next = $request->session + 1;
 
        if(is_null($wallet)) {
            abort(400, 'class wallet not found for '.$request->session .'/'.$session_next);
        }

        return response()->json([
            'data' => [
                'balance' => 'NGN'.number_format($wallet->available_balance, 2),
                'last_payment' => 'NGN'.number_format($wallet->last_amount, 2)
            ]
        ]);
    }

    private function getRandomVoucher($iteration)
    {
         $pin1 = rand(1111,9999);
         $pin2 = rand(1111,9999);
         $pin3 = rand(1111,9999);
         $pin4 = rand(1111,9999);
         
         
         $usedPins = $this->result_vouchers->setResultVoucher()->where('pin1', $pin1)
                                ->where('pin2', $pin2)
                                ->where('pin3', $pin3)
                                ->where('pin4', $pin4)->get();
                                
         if ($usedPins->count() > 0)
         {
             return $this->getRandomVoucher($iteration);
             
         }
         else
         { 
            return array($pin1, $pin2, $pin3, $pin4);
         }
           
    }

    private function getSerialNumber(){
     	$serial = 'SN'.rand(11111111, 99999999);

     	$usedPins = $this->result_vouchers->setResultVoucher()
                                ->where('serial', $serial)->get();
                                
         if ($usedPins->count() > 0)
         {
             return $this->getSerialNumber();
             
         }
         else
         { 
            return $serial;
         }
    }

    public function receipt(Request $request)
    {
        $request->validate([
            'class_id' => 'required|integer',
            'session' => 'required|integer',
            'student_id' => 'required|integer',
            'class_arm_id' => 'required|integer',
            'type' => 'sometimes|integer',
        ]);

        $class_arm_id = $this->class_arms->find($request->input('class_arm_id'));

        $session = $request->session;

        $student = $class_arm_id->students()
                                    ->select('students.id', 'students.surname', 'students.firstname', 
                                        'students.middlename', 'students.regnum',
                                        'students.passport',
                                        'digital_payments.is_verified',
                                        'digital_payments.created_at'
                                        )
                                    ->where('students.id', $request->student_id)
                                    ->wherePivot('session', $request->session)
                                    ->wherePivot('class_id', $request->class_id)
                                    ->join('digital_payments', function($join) use ($session) {
                                        $join->on('students.id', '=', 'digital_payments.student_id')
                                        ->where('digital_payments.session', '=', $session)
                                        ->where('digital_payments.is_verified', '=', 1);
                                   })
                                    ->first();

        $student_voucher = ResultVoucher::where('student_id', '=', $student->id)
                                    ->where('session', $request->session)->first();

        if($student &&  $student_voucher) {

            if($request->has('type') && $request->type == 1) {
                return view('school.reciepts', compact('student', 'student_voucher'));
            }

            return response()->json([
                'data' => [
                    'status' => true,
                    'message' => 'Receipt Available'
                ]
            ]);
        }
        elseif (is_null($student)) {
            return response()->json([
                'data' => [
                    'status' => false,
                    'message' => 'Student not found'
                ]
            ]);
        }
        elseif (is_null($student_voucher)) {
            return response()->json([
                'data' => [
                    'status' => false,
                    'message' => 'Result voucher not found'
                ]
            ]);
        }

       return response()->json([
            'data' => [
                'status' => false,
                'message' => 'Receipt not available'
            ]
       ]);
    }

    public function printBulkReceipt(Request $request)
    {
        $request->validate([
            'class_id' => 'required|integer',
            'session' => 'required|integer',
            'ids' => 'required',
            'ids.*' => 'integer|min:1',
            'class_arm_id' => 'required|integer',
        ]);

        $ids = explode(',', $request->ids);

        $class_arm_id = $this->class_arms->find($request->input('class_arm_id'));

        $session = $request->session;

        $data = [];

        $amount = DB::table('payment_items')->first()->cost + 200;

        foreach ($ids as $id) {
            $student = $class_arm_id->students()
            ->select('students.id', 'students.surname', 'students.firstname', 
                'students.middlename', 'students.regnum',
                'students.passport',
                'digital_payments.is_verified',
                'digital_payments.created_at'
                )
            ->where('students.id', $id)
            ->wherePivot('session', $request->session)
            ->wherePivot('class_id', $request->class_id)
            ->join('digital_payments', function($join) use ($session) {
                $join->on('students.id', '=', 'digital_payments.student_id')
                ->where('digital_payments.session', '=', $session)
                ->where('digital_payments.is_verified', '=', 1);
           })
            ->first();

            $student_voucher = ResultVoucher::where('student_id', '=', $id)
                                    ->where('session', $request->session)->first();

            if($student &&  $student_voucher) {
                $data[] = [
                    'status' => true,
                    'fullname' => "$student->surname $student->firstname $student->middlename",
                    'passport' => $student->passport,
                    'regnum' => $student->regnum,
                    'pin' => $student_voucher->pin,
                    'serial' => $student_voucher->serial,
                    'session' => $student_voucher->session,
                    'amount' => $amount,
                    'created_at' => $student->created_at->diffForHumans()
                ];
            }
            elseif (is_null($student)) {
                $data[] = [
                    'status' => false,
                    'message' => "Student with ID: $id is not found",
                ];
            }
            elseif (is_null($student_voucher)) {
                $data[] = [
                    'status' => false,
                    'message' => "$student->surname $student->firstname result voucher not found",
                ];
            }
        }

       return view('school.bulk_reciepts', compact('data'));
    }
}
