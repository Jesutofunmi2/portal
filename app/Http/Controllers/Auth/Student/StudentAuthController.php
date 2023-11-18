<?php

namespace App\Http\Controllers\Auth\Student;

use App\Http\Controllers\Controller;
use App\Models\Student\Student;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Validator;

class StudentAuthController extends Controller
{
    use AuthenticatesUsers;
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        // $this->middleware('guest:student')->except('logout');
        $this->middleware('guest:student_api')->except('logout');
    }

    public function login(Request $request)
    {
        if($request->isMethod('get')){
            return view('student.auth.login');
        }
        $validator = Validator::make($request->all(), Student::$rulesLogin);

        if ($validator->fails()){
            return response()->json([
                'message' => $validator->errors()->all()
            ], 422);
        }
        if (Auth::guard('student')->attempt(['regnum' => $request->regnum, 'password' => $request->password],true)) {

            Session::put('password-raw', $request->input('password'));
            
            return response()->json([
                'status' => true,
            ], 200);
        }
      
       
        return response()->json([
            'message' => 'credentials not found'    
        ], 401);
    }

   
    public function logout()
    {
        Auth::guard('student')->logout();
        return redirect()->route('student_login_page');
    }

    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('student_api')->factory()->getTTL() * 60,
            'user' => auth('student_api')->user(),
        ]);
    }

    public function refresh() {
        return $this->createNewToken(auth('student_api')->refresh());
    }

    public function api_login(Request $request)
    {
        
        if(! $token = Auth::guard('student_api')->attempt(['regnum' => $request->regnum, 'password' => $request->password])) 
        {
            return response()->json([
                'error' => 'Unauthorized',
                'message' => 'Incorrect Username Or Paassword'], 401);
        }
        //return redirect()->route('ministry_dashboard');
        $token = $this->createNewToken($token);
        return response()->json([
            'message' => 'Login Successfully',
            'url'=>route('student_dashboard'),
            'token' => $token,
            'raw_password' => $request->input('password')
        ], 200);
    }

    public function api_logout()
    {
        Auth::guard('student_api')->logout();
        return response()->json(['message' => 'Logout Successfuly']);
    }

}
