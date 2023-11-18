<?php

namespace App\Models\Teacher;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\SoftDeletes;

    class Teacher extends Authenticatable implements JWTSubject
    {
        use Notifiable, SoftDeletes;
        
        protected $table = 'teachers';

        protected $fillable = [
            'surname',
            'firstname',
            'middlename',
            'school_id',
            'staff_no',
            'staff_no_digit',
            'qualification',
            'gender',
            'address',
            'email',
            'status',
            'phone',
            'session',
            'state_id',
            'lga_id',
            'subjects',
            'password',
            'next_of_kins',
            'next_of_kins_address',
            'next_of_kins_phone',
            'next_of_kins_email',
            'health_status',
            'extra_curricular_activites',
            'health_status_desc' ,
            'marital_status',
            'title',
            'status',
            'passport',
        ];

        protected $guard = 'teacher';

            public static $rulesLogin = [
            'staff_id' => 'required',
            'password' => 'required',
        ];

        protected $hidden = ['password', 'remember_token'];

        public static $rules = [
            'title' => 'required|string|min:2',
            'surname' => 'required|string|min:3',
            'firstname' => 'required|string|min:3',
            'qualification' => 'required|string',
            'gender' => ['required','regex:/^(Male|Female)/'],
            'marital_status' => ['required','regex:/^(Single|Married|Divorce)/'],
            'address' => 'required|string|min:10',
            'email' => 'required|email|unique:teachers,email',
            'phone' => 'required|unique:teachers,phone|regex:(234?)',
            'session' => 'required|integer|digits:4',
            'state_id' => 'required|integer',
            'lga_id' => 'required|integer',
            'subjects' => 'required|array|min:1',
            'password' => 'required|alpha_num|min:6|confirmed',
            'password_confirmation' => 'required|alpha_num|min:6',
            'next_of_kins' => 'required|min:3',
            'next_of_kins_address' => 'required|string|min:10',
            'next_of_kins_phone' => 'required|regex:(234?)',
            'health_status' => ['required', 'regex:/(Normal|Disable)/'],
            'health_status_desc' => 'required|string|min:3'
        ];

            public static $teacherProfileRule = [
            'title' => 'required|min:2',
            'surname' => 'required|min:3',
            'firstname' => 'required|min:3',
            'middlename' => 'sometimes|min:3',
            'gender' => ['required','regex:/(Male|Female)/'],
            'marital_status' => ['required','regex:/^(Signle|Married|Divorce)/'],
            'address' => 'required|min:10',
            'state_id' => 'required|integer',
            'lga_id' => 'required|integer',
            'phone' => 'required|regex:(234?)|digits:13',
            'qualification' => 'required',
            'next_of_kins' => 'required|min:10',
            'next_of_kins_address' => 'required|min:10',
            'next_of_kins_phone' => 'required|regex:(234?)',
            'next_of_kins_email' => 'sometimes|email',
            'health_status' => ['required', 'regex:/(Normal|Disable)/'],
            'health_status_desc' => 'required|min:3'
        ];

        public static $teacherPassportRule = [
            'passport' => 'required|image|mimes:jpeg,jpg,png|img_min_size:250'
        ];

        public static $teacherPasswordRule = [
            'password' => 'required|alpha_num|min:6|confirmed',
            'password_confirmation' => 'required|alpha_num|min:6',
        ];

        public static $teacherSubjectAreaRule = [
            'subjects' => 'required|array|min:1',
        ];

        public static $ruleBatch = [
            'session' => 'required|digits:4',
            'batch_file' => ['required','mimes:xls,xlsx,csv','max:5120']
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
                'userType' => 'Teacher',
            ];
        }
        
        public function subjects() {

            return $this->belongsToMany('App\Models\Subject', 'subject_teacher', 'teacher_id', 'subject_id')->withPivot('school_id');
    
        }
    
        public function permission_classes() {
    
            return $this->belongsToMany('App\Models\Permission', 'class_teacher_permission', 'teacher_id', 'permission_id')->withPivot('classarm_id', 'subject_id');
    
        }
    
        public function houses() {
    
            return $this->belongsToMany('App\Models\StudentHouse', 'house_house_master', 'teacher_id', 'house_id')->withPivot('school_id','session');
    
        }
    
        public function state() {
    
            return $this->belongsTo('App\Models\NgStates', 'state_id');
    
        }
    
        public function statelga() {
    
            return $this->belongsTo('App\Models\NgStatesLGA', 'lga_id');
    
        }
    
        public function classarms() {
    
            return $this->belongsToMany('App\Models\ClassArms', 'classarm_teacher', 'teacher_id', 'classarm_id')->withPivot('session');
    
        }
    
        public function counsellors() {
    
            return $this->belongsToMany('App\Models\ClassArms', 'classarm_counsellor', 'teacher_id', 'classarm_id')->withPivot('session');
    
        }
    
        public function hasPermission($permission) {
            $permissions = array();
            if($this->classarms()->get()->count() > 0){
                foreach ($this->permission_classes()->wherePivot('classarm_id','=',$this->classarms()->get()->toArray()[0]['id'])->get() as $permits) {
                    $permissions[] = $permits->permission_slug;
                }
    
                return in_array($permission, $permissions);
                
            }
    
            return false;
    
        }
    
        public function schools() {
            return $this->belongsTo('\App\Models\School', 'school_id');
        }
    
        public function school() {
            return $this->belongsTo('App\Models\School', 'school_id');
        }
        
        public function attendanceAnalytic() {
            return $this->hasMany('App\Models\AttendanceAnalytic', 'teacher_id');
        }
        
        public function attendanceAnalyticLog() {
            return $this->hasMany('App\Models\AttendanceAnalyticLog', 'teacher_id');
        }

        public function getFullnameAttribute()
        {
            return $this->title.' '.$this->surname.' '.$this->firstname.' '.$this->middlename;
        }
    }