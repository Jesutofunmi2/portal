<?php

namespace App\Http\Controllers\Auth\AEO_ZEO;

use App\Http\Controllers\Controller;
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

class AEO_ZEOAuthController extends Controller
{
    use AuthenticatesUsers;
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:ministry_admin')->except('logout');
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
        $user = Admin::where(['username' => $request->input('username'), 'is_aeozeo' => true])->first();
    
        if(($user) && (Hash::check($request->input('password'), $user->password))) {

            //check if user has verify email...
            // if (is_null($user->email_verified_at)) {
            //     Session::put('user', $user);
            //    abort(400, "Please verify  your email");
            // }
          
            $otp = OtpGenerator::generateAndSaveOtp($user->username, 'aeozeo');

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
        if($request->isMethod('get')) {
            return view('aeo_zeo.auth.login');
        }

        $validator = Validator::make($request->all(), Admin::$rulesLogin);

        if ($validator->fails()){
            return response()->json([
                'message' => $validator->errors()->all()
            ], 422);
        }
       
        $status = OtpGenerator::confirmOTP($request->username, $request->otp, 'aeozeo');

        if($status==1){
            if (Auth::guard('ministry_admin')->attempt(['username' => $request->username, 'password' => $request->password], true)) {

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
        return redirect()->route('aeo_zeo_login_page');
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
        $user = Admin::where(['username' => $request->input('username'), 'is_aeozeo' => true])->exists();
    
        if(! $user) {
               abort(400, "Incorrect Username Or Password");
        }

        if(! $token = Auth::guard('ministry_api')->attempt(['username' => $request->username, 'password' => $request->password])) 
        {
            return response()->json([
                'error' => 'Unauthorized',
                'message' => 'Incorrect Username Or Password'], 401);
        }

        //return redirect()->route('ministry_dashboard');
        $token = $this->createNewToken($token);
        return response()->json([
            'message' => 'Login Successfully',
            'url'=>route('aeo_zeo_dashboard'),
            'token' => $token,
        ], 200);
    }

    public function api_logout()
    {
        Auth::guard('ministry_api')->logout();
        return response()->json(['message' => 'Logout Successfuly']);
    }
    

    
}
