<?php

namespace App\Models\Liberian;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

    class Liberian extends Authenticatable implements JWTSubject
    {
        use Notifiable;

        protected $table = 'liberians';

        protected $guard = 'liberian';

        protected $fillable = ['fullname', 'school_id', 'username', 'email', 'password', 'status', 'phone'];

        protected $hidden = ['password', 'remember_token'];

        public static $rules = [
            'fullname' => 'required|min:6',
            'username' => 'required|min:4|unique:liberians,username',
            'email' => 'required|email|unique:liberians,email',
            'password' => 'required|alpha_num|min:6|confirmed',
            'password_confirmation' => 'required',
            'school_id' => 'required|integer',
            'phone' => 'required|regex:(234?)|digits:13|unique:liberians,phone',
            'permissions' => 'required|array|min:1'
        ];
        public static $rulesLogin = [
            'username' => 'required|min:3',
            'password' => 'required',
            //'school' => 'required|integer'
        ];

        public static $schoolLiberianPasswordRule = [
            'password' => 'required|alpha_num|min:6|confirmed',
            'password_confirmation' => 'required|alpha_num|min:6',
        ];

        public function getJWTIdentifier() {
            return $this->getKey();
        }
    
        /**
         * Return a key value array, containing any custom claims to be added to the JWT.
         *
         * @return array
         */
        public function getJWTCustomClaims() {
            return [
                'userType' => 'Liberian',
            ];
        }    

    }