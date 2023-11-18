<?php

namespace App\Models\School;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\SoftDeletes;

    class Admin extends Authenticatable implements JWTSubject
    {
        use Notifiable, SoftDeletes;

        protected $table = 'admins';

        protected $guard = 'school_admin';

        protected $fillable = ['fullname', 'school_id', 'username', 'email', 'password', 'status', 'phone'];

        protected $hidden = ['password', 'remember_token'];

        public static $rules = [
            'fullname' => 'required|min:6',
            'username' => 'required|min:4|unique:admins,username',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|alpha_num|min:6|confirmed',
            'password_confirmation' => 'required',
            'school' => 'required|integer',
            'phone' => 'required|regex:(234?)|digits:13|unique:admins,phone',
            'permissions' => 'required|array|min:1'
        ];
        public static $rulesLogin = [
            'username' => 'required|min:3',
            'password' => 'required',
            //'school' => 'required|integer'
        ];

        public static $schoolAdminPasswordRule = [
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
                'userType' => 'SchoolAdmin',
            ];
        }    

        public function permissions(){

            return $this->belongsToMany('\App\Models\Permission', 'admin_permission', 'admin_id');
    
        }
    
        public function hasPermission($permission){
            $permissions = array();
            foreach ($this->permissions as $permits) {
                $permissions[] = $permits->permission_slug;
            }
    
            return in_array($permission, $permissions);
    
        }
    
        public function schools(){
            return $this->belongsTo('\App\Models\School', 'school_id');
        }
    
        public function school(){
            return $this->belongsTo('App\Models\School', 'school_id');
        }
    
    
        public function adminschool($admin){
            $this->schools()->associate($admin);
            return $this;
        }
    

    }