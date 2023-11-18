<?php

namespace App\Http\Controllers\Auth\Teacher;

use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Mail\SendVerificationLink;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Auth\Encryption;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Interfaces\TeacherRepositoryInterface;
use Exception;

class EmailVerificationController extends Controller
{
    //
    public $teacher;

    public function __construct(TeacherRepositoryInterface $teacher) {
        $this->teacher = $teacher;
    }
    
    public function updateEmail(Request $request)
    {
        if ( is_null(Session::get('user'))) {
            return redirect()->route('teacher_login_page');
        }

        $user = Session::get('user')->toArray();
        
        return view('teacher.auth.email-verification',compact('user'));
    }

    public function sendVerification(Request $request)
    {
        if ( is_null(Session::get('user'))) {
            abort(400, "An error occur, please try again");
        }

       $this->validate($request,[
           'email' => ['required', 'email', 'unique:teachers,email,'.$request->user_id],
           'user_id' => ['required', 'integer'],
       ]);

        $user = Session::get('user')->toArray();

        if ($user['id'] != $request->user_id){
            abort(400, "An error occur, please try again");
        }

        // fetch from db
        $user = $this->teacher->find($request->user_id);
        if ( ! is_null($user->email_verified_at)) {
            abort(400, "Email has already been verified");
        }

    
       $this->teacher->find($request->user_id)->update(['email' => $request->email]);

       $token = Encryption::encrypter($user['firstname']);
       $link = route('teacherEmailVerify').'?email='.$request->email.'&token='.$token;
    
       
       try {
        Mail::to($request->email)->send(new SendVerificationLink($user['firstname'], $link));
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
            return redirect()->route('teacher_login_page')->withErrors($validation);
        }

        $user = $this->teacher->setTeacher()->where('email', $request->email)->first();

        if ( is_null($user)) {
            return redirect()->route('teacher_login_page')->withErrors("Unknown User, please try again");
        }

        if ( ! is_null($user->email_verified_at)) {
            return redirect()->route('teacher_login_page')->withErrors("Email has already been verified");
        }

        $decrypted = Encryption::decrypter($request->token);

        if ($user->firstname != $decrypted){
            return redirect()->route('teacher_login_page')->withErrors("Invalid token, please try again");
        }

        $user = $this->teacher->setTeacher()->where('email', $request->email)->update(['email_verified_at' => Carbon::now()]);
      
        return redirect()->route('teacher_login_page')->withSuccess("Email verified successfully, please login");
    }
}
