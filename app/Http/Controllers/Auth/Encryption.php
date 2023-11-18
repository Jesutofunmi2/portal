<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Crypt;


class Encryption
{
    public static function encrypter(String $value): String
    {
        return Crypt::encryptString($value);
    }

    public static function decrypter($token): String
    {
        try {
            $decrypted = Crypt::decryptString($token);
            return $decrypted;
        } catch (DecryptException $e) {
            //
            $e->getMessage();
        }
    }

    
}