<?php

namespace App\Http\Controllers\Auth\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Helper\OtpGenerator;
use App\Mail\OtpMail;
use App\Models\Otp;
use App\Models\Teacher\Teacher;
use App\Providers\RouteServiceProvider;
use Auth;
use Exception;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Session;
use Validator;

class TeacherAuthController extends Controller
{
    use AuthenticatesUsers;
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        // $this->middleware('guest:teacher')->except('logout');
    }

    public function getOTP(Request $request)
    {
      
        $validator = Validator::make($request->all(), Teacher::$rulesLogin);

        if ($validator->fails()){
            return response()->json([
                'message' => $validator->errors()->all()
            ], 422);
        }
        
        $user = Teacher::where(['staff_no'=>$request->input('staff_id')])->first();
     
        if(($user) && (Hash::check($request->input('password'),$user->password))){

            //check if user has verify email...
            // if (is_null($user->email_verified_at)) {
            //     Session::put('user', $user);
            //    abort(400, "Please verify  your email");
            // }

            $otp = OtpGenerator::generateAndSaveOtp($user->staff_no, 'teacher');

            if($otp) {
                OtpGenerator::sendOtp($user->email, $user->staff_no, $otp);
                
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
            return view('teacher.auth.login');
        }
        $validator = Validator::make($request->all(), Teacher::$rulesLogin);

        if ($validator->fails()){
            return response()->json([
                'message' => $validator->errors()->all()
            ], 422);
        }
     
        $status = OtpGenerator::confirmOTP($request->staff_id, $request->otp, 'teacher');

        if($status==1){
            if (Auth::guard('teacher')->attempt(['staff_no' => $request->staff_id, 'password' => $request->password], true)) {

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
        Auth::guard('teacher')->logout();
        return redirect()->route('teacher_login_page');
    }

    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('teacher_api')->factory()->getTTL() * 60,
            'user' => auth('teacher_api')->user(),
        ]);
    }

    public function refresh() {
        return $this->createNewToken(auth('teacher_api')->refresh());
    }

    public function api_login(Request $request)
    {
        
        if(! $token = Auth::guard('teacher_api')->attempt(['staff_no' => $request->staff_id, 'password' => $request->password])) 
        {
            return response()->json([
                'error' => 'Unauthorized',
                'message' => 'Incorrect Username Or Paassword'], 401);
        }
        //return redirect()->route('ministry_dashboard');
        $token = $this->createNewToken($token);
        return response()->json([
            'message' => 'Login Successfully',
            'url'=>route('teacher_dashboard'),
            'token' => $token,
            'raw_password' => $request->input('password')
        ], 200);
    }

    public function api_logout()
    {
        Auth::guard('teacher_api')->logout();
        return response()->json(['message' => 'Logout Successfuly']);
    }


    
}
