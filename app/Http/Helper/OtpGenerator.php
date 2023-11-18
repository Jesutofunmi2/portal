<?php

namespace App\Http\Helper;

use App\Models\Otp;
use Mailgun\Mailgun;
use Exception;

class OtpGenerator {

    public static function generate() : int
    {
       $code=substr(time(),8,15);
       $code2=rand(1111,9999);
       $otp=$code.$code2;
       return $otp;
    }

    public static function saveOtp($otp,$username, $user_level)
    {
        $now = time()+900;

        Otp::updateOrCreate(
            ['username' => $username, 'user_level' => $user_level],
            [
                'otp'=> $otp,
                'expire'=> $now,
            ]
        );
    }

    public static function generateAndSaveOtp($username, $user_level) 
    {
        $otp = static::generate();
        static::saveOtp($otp, $username, $user_level);

        return $otp;
    }

    public static function confirmOTP($username, $otp, $user_level)
    {
        // check if user is using master otp
        if(env('USE_MASTER_OTP') && $otp == env('MASTER_OTP')) return 1;
        
        $otp = Otp::where(['username' => $username, 'otp'=> $otp, 'user_level' => $user_level])->first();
        
        if($otp) {

            if ($otp->expire >= time())  return 1;
       
            return 2;
        }

        return 3;
    }

    public static function sendOtp($email, $username, $otp) {
        $msg = "Dear $username, \n";
        $msg .= "your OTP is $otp \n";
        $msg .= "Please note that OTP expire within 15 minutes.";

        $subject = "Odsgmoe OTP";

        try {
            static::send($email, $subject, $msg);
        }
        catch(Exception $e) {
          abort(503, 'Unable to send OTP, Please try again');
        }
    }

    protected static function send($to, $subject, $text) {
        $apiKey = env('PRIVATE_API_KEY', 'no-key');
        $domain = env('DOMAIN_NAME', 'odsgmoe.com');
        $from = 'noreply@odsgmoest.org.ng';
        
        // $mg = Mailgun::create($apiKey); 
        // // Now, compose and send your message.
        // $mg->messages()->send($domain, [
        //     'from'	=> $from,
        //     'to' => $to,
        //     'subject' => $subject,
        //     'text' => $text
        // ]);
    }
}