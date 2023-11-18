<?php

namespace App\Models\Ministry;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\SoftDeletes;


    class Admin extends Authenticatable implements JWTSubject
    {
        use Notifiable, SoftDeletes;

        protected $guard = 'ministry_admin';
        protected $table = 'super_admins';

        protected $fillable = [
            'email',
            'fullname',
            'username',
            'password',
            'status',
            'phone',
            'login_count',
            'update_level',
            'lgas',
            'is_aeozeo',
            'is_cas_admin'
        ];
        protected $casts = [
            'lgas' => 'array', 
            'is_aeozeo' => 'boolean',
            'is_cas_admin' => 'boolean'
        ];
     
        public static $rules = [
            'fullname' => 'required|min:6',
            'username' => 'required|min:4|unique:super_admins,username',
            'email' => 'required|email|unique:super_admins,email',
            'phone' => 'required|min:4|unique:super_admins,phone|regex:(234?)',
            'password' => 'required|alpha_num|min:6|confirmed',
            'password_confirmation' => 'required',
            'lgas' => 'sometimes|array|min:1'
        ];
    
        public static $rulesLogin = [
            'username' => 'required|min:3',
            'password' => 'required',
        ];

        protected $hidden = [
            'password', 'remember_token',
        ];

        public function permissions(){
            return $this->belongsToMany('\App\Models\Permission', 'super_admin_permission', 'super_admin_id');
        }
    
        public function hasPermission($permission){
            $permissions = array();
            foreach ($this->permissions as $permits) {
                $permissions[] = $permits->permission_slug;
            }
    
            return in_array($permission, $permissions);
        }

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
                'userType' => 'MinistryAdmin',
            ];
        }    

        public static $schoolAdminPermissions = [1,2,3,4,5,6,7,8,9,10,11,12,13,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,55,55,56,57];

        public function tasks(){
            return $this->belongsToMany('App\Models\Task', 'tasks_members', 'super_admin_id', 'task_id');
        }
    
        public function department(){
            return $this->belongsTo('App\Models\MinistryDepartment', 'department_id');
        }
    }