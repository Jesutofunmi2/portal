<?php

namespace App\Http\Controllers\Auth\Ministry;

use App\Http\Controllers\Controller;
use App\Http\Helper\EmailHelper;
use App\Http\Helper\OtpGenerator;
use App\Mail\OtpMail;
use App\Models\Ministry\Admin;
use Exception;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use AuthenticatesUsers;
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        // $this->middleware('guest:ministry_admin')->except('logout');
        $this->middleware('guest:ministry_api')->except('logout');
    }

    public function getOTP(Request $request)
    {
      
        $validator = Validator::make($request->all(), Admin::$rulesLogin);

        if ($validator->fails()){
            return response()->json([
                'message' => $validator->errors()->all()
            ], 422);
        }

        $user = Admin::where(['username' => $request->input('username'), 'is_aeozeo' => false, 'is_cas_admin' => false])->first();
    
        if (($user) && (Hash::check($request->input('password'), $user->password))) {          
            $otp = OtpGenerator::generateAndSaveOtp($user->username, 'ministry');

            if($otp) {
                OtpGenerator::sendOtp($user->email, $user->username, $otp);
                
                return response()->json([
                    'message' => 'OTP Sent, Kindly check your mail'    
                ], 200);
            }
        }
        else {
            return response()->json([
                'message' => 'credentials not found'    
            ], 401);
        }
    }

    public function getCasOTP(Request $request)
    {
        $validator = Validator::make($request->all(), Admin::$rulesLogin);

        if ($validator->fails()){
            return response()->json([
                'message' => $validator->errors()->all()
            ], 422);
        }
        
        $user = Admin::where(['username' => $request->input('username'), 'is_cas_admin' => true])->first();
    
        if(($user) && (Hash::check($request->input('password'), $user->password))){
          
            $otp = OtpGenerator::generateAndSaveOtp($user->username, 'ministry');

            if($otp) {
                OtpGenerator::sendOtp($user->email, $user->username, $otp);
                
                return response()->json([
                    'message' => 'OTP Sent, Kindly check your mail'    
                ], 200);
            }
        }
        else{
            return response()->json([
                'message' => 'credentials not found'    
            ], 401);
        }
    }

    public function login(Request $request)
    {
        if($request->isMethod('get')){
            return view('ministry.auth.login');
        }
  
        $validator = Validator::make($request->all(), Admin::$rulesLogin);

        if ($validator->fails()){
            return response()->json([
                'message' => $validator->errors()->all()
            ], 422);
        }
        
        $status = OtpGenerator::confirmOTP($request->username, $request->otp, 'ministry');

        if($status==1){
            if (Auth::guard('ministry_admin')->attempt(['username' => $request->username, 'password' => $request->password], true)) {
                $user = auth('ministry_admin')->user();
                
                if ($user->is_cas_admin || $user->is_aeozeo) {
                    Auth::guard('ministry_admin')->logout();

                    return response()->json([
                        'message' => 'Credentials not found'    
                    ], 401);
                }
                Session::put('password-raw', $request->input('password'));

                return response()->json([
                    'status' => true,
                ], 200);
            }
        }
        elseif($status==2){
            return response()->json([
                'message' => 'OTP Expired'    
            ], 401);
        }
        elseif ($status==3) {
            return response()->json([
                'message' => 'Invalid OTP'    
            ], 401);
        }
    
        return response()->json([
            'message' => 'credentials not found'    
        ], 401);
    }

    public function casLogin(Request $request)
    {
        if($request->isMethod('get')){
            return view('cas.auth.login');
        }
  
        $validator = Validator::make($request->all(), Admin::$rulesLogin);

        if ($validator->fails()){
            return response()->json([
                'message' => $validator->errors()->all()
            ], 422);
        }
        
        $status = OtpGenerator::confirmOTP($request->username, $request->otp, 'ministry');

        if($status==1){
            if (Auth::guard('ministry_admin')->attempt(['username' => $request->username, 'password' => $request->password], true)) {
                $user = auth('ministry_admin')->user();

                if (!$user->is_cas_admin) {
                    Auth::guard('ministry_admin')->logout();
                    
                    return response()->json([
                        'message' => 'Credentials not found'    
                    ], 401);
                }
                Session::put('password-raw', $request->input('password'));

                return response()->json([
                    'status' => true,
                ], 200);
            }
        }
        elseif($status==2){
            return response()->json([
                'message' => 'OTP Expired'    
            ], 401);
        }
        elseif ($status==3) {
            return response()->json([
                'message' => 'Invalid OTP'    
            ], 401);
        }
    
        return response()->json([
            'message' => 'credentials not found'    
        ], 401);
    }

    public function logout()
    {
        Auth::guard('ministry_admin')->logout();
        return redirect()->route('ministry_login_page');
    }

    public function casLogout()
    {
        Auth::guard('ministry_admin')->logout();
        return redirect()->route('cas_login_page');
    }

    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('ministry_api')->factory()->getTTL() * 60,
            'user' => auth('ministry_api')->user(),
        ]);
    }

    public function refresh() {
        return $this->createNewToken(auth('ministry_api')->refresh());
    }

    public function api_login(Request $request)
    {
        if(! $token = Auth::guard('ministry_api')->attempt(['username' => $request->username, 'password' => $request->password])) 
        {
            return response()->json([
                'error' => 'Unauthorized',
                'message' => 'Incorrect Username Or Paassword'], 401);
        }

        $url = route('ministry_dashboard');
        $user = auth('ministry_api')->user();

        if($user->is_cas_admin) {
            $url = route('cas_dashboard');
        }
        //return redirect()->route('ministry_dashboard');
        $token = $this->createNewToken($token);
        return response()->json([
            'message' => 'Login Successfully',
            'url'=> $url,
            'token' => $token,
            'raw_password' => $request->input('password')
        ], 200);
    }

    public function api_logout()
    {
        Auth::guard('ministry_api')->logout();
        return response()->json(['message' => 'Logout Successfuly']);
    }
    
}
