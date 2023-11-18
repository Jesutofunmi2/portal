<?php

namespace App\Models\Student;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Authenticatable implements JWTSubject
{
    use Notifiable, SoftDeletes;
    protected $table = 'students';


    protected $fillable = [
        'surname',
        'firstname',
        'middlename',
        'regnum',
        'regnum_digit',
        'school_id',
        'dob',
        'gender',
        'country',
        'address',
        'state_id',
        'lga_id',
        'religion',
        'password',
        'password_confirmation',
        'parent_fullname',
        'parent_address',
        'parent_email',
        'parent_phone',
        'session',
        'house_id',
        'blood_group',
        'status',
        'phone',
        'passport',
    ];


    protected $guard = 'student';

    public static $rulesLogin = [
        'regnum' => 'required',
        'password' => 'required',
        //'school' => 'required'
    ];

    protected $hidden = ['password', 'remember_token'];

    public static $rules = [
        'surname' => 'required|min:3',
        'firstname' => 'required|min:3',
        'dob' => 'required|date',
        'gender' => ['required','regex:/(Male|Female)/'],
        'country' => 'required',
        'address' => 'required|min:10',
        'state_id' => 'required|integer|not_in:0',
        'lga_id' => 'required|integer|not_in:0',
        'house_id' => 'required|integer|not_in:0',
        'religion' => ['required','regex:/(Christian|Muslim|Traditional)/'],
        'password' => 'required|alpha_num|min:6|confirmed',
        'password_confirmation' => 'required|alpha_num|min:6',
        'parent_fullname' => 'required',
        'parent_address' => 'required',
        'parent_email' => 'required|uniqueFirstAndLastName:surname,firstname,session',
        'parent_phone' => 'required|regex:(234?)|digits:13',
        'session' => 'required|digits:4',
        'term' => ['required','regex:/(First|Second|Third)/'],
        'class_id' => 'required|integer',
        'class_arm_id' => 'required|integer',
        'phone' => 'sometimes|regex:(234?)|digits:13',
        'blood_group' => ['required','regex:/(A+|A-|B+|B-|AB+|AB-|O+|O-)/'],
    ];

    public static $studentProfileRule = [
        'surname' => 'required|min:3',
        'firstname' => 'required|min:3',
        'dob' => 'required|date',
        'gender' => ['required','regex:/(Male|Female)/'],
        'country' => 'required',
        'address' => 'required|min:10',
        'state_id' => 'required|integer',
        'lga_id' => 'required|integer',
        'religion' => ['required','regex:/(Christian|Muslim|Traditional)/'],
            'phone' => 'sometimes|regex:(234?)|digits:13'
    ];

    public static $studentPassportRule = [
        'passport' => 'required|image|mimes:jpeg,jpg,png|img_min_size:250'
    ];

    public static $studentPasswordRule = [
        'password' => 'required|alpha_num|min:6|confirmed',
        'password_confirmation' => 'required|alpha_num|min:6',
    ];

    public static $studentResultSelectRule = [
        'session' => 'required|digits:4',
        'term' => ['required','regex:/(First|Second|Third)/'],
        'class_arm_id' => 'required|integer',
        'class_id' => 'required|integer',
    ];

    public static $ruleBatch = [
        'session' => 'required|digits:4',
        'term' => ['required','regex:/(First|Second|Third)/'],
        'class_id' => 'required|integer',
        'class_arm_id' => 'required|integer',
        'pseudo_batch_file_name' => ['required','allowexts:xls,xlsx,csv', 'excelFormatAllowed:13', 'school_check']
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
            'userType' => 'Student',
        ];
    }

    public function subjectsUnoffered() {

        return $this->belongsToMany('App\Models\Subject', 'student_subject_unoffered', 'student_id', 'subject_id')->withPivot('session', 'classarm_id');
    
    }
    
    public function state() {

    	return $this->belongsTo('App\Models\NgStates','state_id');

    }

    public function statelga() {

    	return $this->belongsTo('App\Models\NgStatesLGA', 'lga_id');

    }

    public function classes() {

    	return $this->belongsTo('App\Models\Classes', 'class_id');

    }

    public function class_arm() {

    	return $this->belongsTo('App\Models\ClassArms', 'class_arm_id');

    }

    public function classarms() {

        return $this->belongsToMany('App\Models\ClassArms', 'classarm_student', 'student_id', 'classarm_id')->withPivot('session', 'term', 'class_id');

    }

     public function idCardRequest() {

        return $this->hasMany('App\Models\StudentIDCardRequest', 'school_id');

    }

    public function studentResults() {

        return $this->hasMany('App\Models\StudentResult', 'student_id');

    }

    public function studentPracticalSkills() {

        return $this->hasMany('App\Models\PracticalSkill', 'student_id');

    }

    public function studentCharacterAttitudes() {

        return $this->hasMany('App\Models\CharacterAttitude', 'student_id');

    }

    public function StudentResultVouchers() {
        return $this->hasMany('App\Models\ResultVoucher', 'student_id');
    }

    public function schools() {
        return $this->belongsTo('\App\Models\School', 'school_id');
    }

    public function school() {
        return $this->belongsTo('App\Models\School', 'school_id');
    }

    public function studentIDCard() {
        return $this->hasOne('App\Models\StudentIDCard', 'student_id');
    }

    public function beforeTransfer() {
        return $this->hasMany('App\Models\Transfer', 'student_former_id');
    }
    
    public function digitalPayment() {
        return $this->hasMany('App\Models\DigitalPayment', 'student_id');
    }

    public function afterTransfer() {
        return $this->hasMany('App\Models\Transfer', 'student_new_id');
    }

    public function attendanceAnalyticLog() {
        return $this->hasMany('App\Models\AttendanceAnalyticLog', 'student_id');
    }
    
    public function subjectAttendanceAnalyticLog() {
        return $this->hasMany('App\Models\SubjectAttendanceAnalyticLog', 'student_id');
    }
    
    public function classAttendanceAnalyticLog() {
        return $this->hasMany('App\Models\ClassAttendanceAnalyticLog', 'student_id');
    }

    public function getFullnameAttribute()
    {
        return $this->surname.' '.$this->firstname.' '.$this->middlename;
    }
    
}