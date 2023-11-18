<?php

namespace App\Http\Controllers\Auth\AEO_ZEO;

use App\Http\Controllers\Auth\Encryption;
use App\Http\Controllers\Controller;
use App\Mail\SendPasswordReset;
use App\Models\AEO_ZEO\AEO_ZEO;
use App\Models\Ministry\Admin;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ForgetPassword extends Controller
{
    public function forget(Request $request)
    {
        if($request->isMethod('post')) {
            $user =  Admin::where(['username' => $request->username, 'is_aeozeo' => true])->first();

           if(is_null($user)) {
                abort(400, 'Username does not exist');
           }

           if(is_null($user->email)) {
                abort(400, 'Email is not found on this account');
            }

            $email = $user->email;
            $username = $user->username;
            $expire_date = time() + 900;
            $expire_date = Encryption::encrypter($expire_date);
            $token = Encryption::encrypter($user->fullname);
            $link = route('aeo_zeo_reset_password').'?email='.$email.'&token='.$token.'&expire='.$expire_date;

           try {
                Mail::to($email)->send(new SendPasswordReset($username, $link));
            }
            catch(Exception $e) {
                abort(503, 'Unable to send password reset mail, Please try again');
            }


            return response()->json([
                'message' => 'Password reset link have been sent to your email, Link expire in 15min.'
            ]);
        }

        return view('aeo_zeo.auth.forget-password');
    }

    public function reset(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'token' => ['required'],
            'expire' => ['required']
        ]);

        if ( ! $validation->passes()) {
            return redirect()->route('aeo_zeo_forget_password')->withErrors($validation);
        }

        $user =  Admin::whereEmail($request->email)->first();

        if(is_null($user)) {
            return redirect()->route('aeo_zeo_forget_password')->withErrors('User not found');
        }

        $decrypted = Encryption::decrypter($request->token);

        if ($user->fullname != $decrypted){
            return redirect()->route('aeo_zeo_forget_password')->withErrors("Invalid token, please try again");
        }

        $expire_date = Encryption::decrypter($request->expire);
        $now = time();

        if ($now > $expire_date){
            return redirect()->route('aeo_zeo_forget_password')->withErrors("Link expired, please try again");
        }

        return view('aeo_zeo.auth.reset-password')->with([
            'username' => $user->username,
            'email' => $user->email,
            'reset_token' => $request->token
        ]);
    }

    public function set(Request $request)
    {
        $this->validate($request, [
            'email' => ['required', 'email'],
            'reset_token' => ['required'],
            'password' => ['required', 'alpha_num', 'confirmed'],
            'password_confirmation' => ['required', 'alpha_num']
        ]);

        $user =  Admin::whereEmail($request->email)->first();

        if(is_null($user)) {
            abort(400, 'User not found');
        }

        $decrypted = Encryption::decrypter($request->reset_token);

        if ($user->fullname != $decrypted){
            abort(400, "Invalid token, please try again");
        }

        $user = Admin::whereEmail($request->email)->update(['password' => Hash::make($request->password)]);

        return response()->json([
            'message' => 'Password set successfully, please proceed to login'
        ]);
    }
}
