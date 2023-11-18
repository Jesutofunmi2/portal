<?php

namespace App\Http\Controllers\Auth\Ministry;

use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Mail\SendVerificationLink;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Auth\Encryption;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Interfaces\SuperAdminRepositoryInterface;
use Exception;

class EmailVerificationController extends Controller
{
    //
    public $admin;

    public function __construct(SuperAdminRepositoryInterface $admin) {
        $this->admin = $admin;
    }
    
    public function updateEmail(Request $request)
    {
        if ( is_null(Session::get('user'))) {
            return redirect()->route('ministry_login_page');
        }

        $user = Session::get('user')->toArray();
        
        return view('ministry.auth.email-verification',compact('user'));
    }

    public function sendVerification(Request $request)
    {
        if ( is_null(Session::get('user'))) {
            abort(400, "An error occur, please try again");
        }

       $this->validate($request,[
           'email' => ['required', 'email', 'unique:super_admins,email,'.$request->user_id],
           'user_id' => ['required', 'integer'],
       ]);

        $user = Session::get('user')->toArray();

        if ($user['id'] != $request->user_id){
            abort(400, "An error occur, please try again");
        }
    
       $this->admin->find($request->user_id)->update(['email' => $request->email]);

       $token = Encryption::encrypter($user['fullname']);
       $link = route('ministryEmailVerify').'?email='.$request->email.'&token='.$token;
    
       try {
        Mail::to($request->email)->send(new SendVerificationLink($user['fullname'], $link));
        }
        catch(Exception $e) {
            abort(503, 'Unable to send verification email, Please try again');
        }

       return response()->json([
           'message' => 'Email verification link have been sent successfully'
       ]);
    }

    public function verify(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'token' => ['required']
        ]);

        if ( ! $validation->passes()) {
            return redirect()->route('ministry_login_page')->withErrors($validation);
        }

        $user = $this->admin->setSuperAdmin()->where('email', $request->email)->first();

        if ( is_null($user)) {
            return redirect()->route('ministry_login_page')->withErrors("Unknown User, please try again");
        }

        if ( ! is_null($user->email_verified_at)) {
            return redirect()->route('ministry_login_page')->withErrors("Email has already been verified");
        }

        $decrypted = Encryption::decrypter($request->token);

        if ($user->fullname != $decrypted){
            return redirect()->route('ministry_login_page')->withErrors("Invalid token, please try again");
        }

        $user = $this->admin->setSuperAdmin()->where('email', $request->email)->update(['email_verified_at' => Carbon::now()]);
      
        return redirect()->route('ministry_login_page')->withSuccess("Email verified successfully, please login");
    }
}
