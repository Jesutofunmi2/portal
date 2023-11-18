<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class EntranceExam extends Authenticatable
{
     protected $table = 'entrance_exams';

    protected $guard = 'entrance_exam';

    protected $fillable = [
        'pin',
        'serial',
        'agent_id',
        'surname',
        'firstname',
        'middlename',
        'regnum',
        'blood_group',
        'dob',
        'gender',
        'country',
        'address',
        'state_id',
        'lga_id',
        'religion',
        'password',
        'parent_fullname',
        'parent_address',
        'parent_email',
        'parent_phone',
        'session',
        'first_choice',
        'second_choice',
        'phone'
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
		'religion' => ['required','regex:/(Christian|Muslim|Traditional)/'],
        'blood_group' => ['required','regex:/(O+|O-|A+|A-|B+|B-|AB+|AB-)/'],
		'parent_fullname' => 'required',
		'parent_address' => 'required',
		'parent_email' => 'required|uniqueFirstAndLastName:surname,firstname,session',
		'parent_phone' => 'required|regex:(234?)|digits:13',
        'phone' => 'sometimes|regex:(234?)|digits:13',
        'first_choice' => 'required|integer',
        'second_choice'  => 'required|integer'

	];

	public static $studentPassportRule = [
        'student_id' => 'required|integer|not_in:0',
        'passport' => 'required|image|mimes:jpeg,jpg,png|img_min_size:250'
    ];

    public function state(){

    	return $this->belongsTo('App\Models\NgStates','state_id');

    }

    public function statelga(){

    	return $this->belongsTo('App\Models\NgStatesLGA', 'lga_id');

    }

    public function first_choices(){

    	return $this->belongsTo('App\Models\School','first_choice');

    }

    public function second_choices(){

    	return $this->belongsTo('App\Models\School', 'second_choice');

    }

    public function hall_allocation(){
        return $this->hasOne('App\Models\EntranceHallAllocation', 'candidate_id');
    }

    public function agent(){
        return $this->belongsTo('App\Models\Agent', 'agent_id');
    }
}
