<?php

namespace App\Models;

use App\Models\Ministry\Admin;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $table = "schools_new";

    protected $fillable = ['name', 'wallet_id', 'state_id', 'lga_id', 'logo', 'address', 'phone', 'school_category', 'next_session_date', 'principal_name', 'principal_sign', 'counsellor_name', 'counsellor_sign'];

    public static $rules = [
    	'school' => 'required|min:5',
    	'lga_id' => 'required|integer',
        'school_category' => ['required','regex:/(unity|non_unity)/'],
        'logo' => 'sometimes|image|mimes:jpeg,jpg,png|max:2048',
        'address' => 'required|min:10',
    ];
    public static $updateRules = [
    	'school' => 'required|min:5',
    	'lga_id' => 'required|integer',
        'school_category' => ['required','regex:/(unity|non_unity)/'],
        'address' => 'required|min:10',
    ];

     public static $ruleBatch = [
        'state_id' => 'required|integer',
        'lga_id' => 'required|integer',
        'school_category' => ['required','regex:/(unity|non_unity)/'],
        'pseudo_batch_file_name' => ['required','allowexts:xls,xlsx,csv', 'excelFormatAllowed:1']
    ];

    public function present_schools_for_display($schools){
    	$school_options = '';
    	foreach($schools as $school){
    	 	 $school_options .= '<div class="item" data-value="'.$school->id.'">'.$school->name.'</div>';
    	 }
    	 return $school_options;
    }


    //new
    public function schoolTeacher(){
        return $this->hasMany('App\Models\Teacher\Teacher', 'school_id');
    }

    public function schoolStudent(){
        return $this->hasMany('App\Models\Student\Student', 'school_id');
    }

    public function schoolAdmin(){
        return $this->hasMany('App\Models\School\Admin', 'school_id');
    }

    public function schoolSurvey(){
        return $this->hasMany('App\Models\SchoolSurvey', 'school_id');
    }

    public function schoolSurveyMonthly(){
        return $this->hasMany('App\Models\SchoolSurveyMonthly', 'school_id');
    }

    public function ondoLga(){
        return $this->belongsTo('App\Models\OndoLGA', 'lga_id');
    }

    public function statesLGA(){
        return $this->belongsTo('App\Models\NgStatesLGA', 'lga_id');
    }
    //end new
    
    public function transaction(){
        return $this->hasMany('App\Models\Transaction', 'school_id');
    }
    
    public function wallet(){
        return $this->belongsTo('App\Models\Wallet');
    }
    
    public function admins(){
        return $this->hasMany('App\Models\School\Admin', 'school_id');
    }

    public function teachers(){
        return $this->hasMany('App\Models\Teacher\Teacher', 'school_id');
    }

    public function students(){
        return $this->hasMany('App\Models\Student\Students', 'school_id');
    }

    public function assessment(){
        return $this->hasMany('App\Models\Assessment', 'school_id');
    }

    public function ondo_lga(){
        return $this->belongsTo('App\Models\OndoLGA', 'lga_id');
    }

    public function schoolIDCard(){
        return $this->hasOne('App\Models\SchoolIDTemplate', 'school_id');
    }

    public function studentIDCard(){
        return $this->hasOne('App\Models\StudentIDCard', 'school_id');
    }

    public function classes(){
        return $this->hasMany('App\Models\Classes', 'school_id');
    }

    public function school_houses(){
         return $this->hasMany('App\Models\StudentHouse', 'school_id');
    }
    
    public function idCardRequest(){
        return $this->hasMany('App\Models\StudentIDCardRequest', 'school_id');
    }
    
    public function pendingIdCardRequest(){
        return StudentIDCardRequest::where('is_verified', false)->where('school_id', $this->id)->get();
    }
    
    public function approveIdCardRequest(){
        return StudentIDCardRequest::where('is_verified', true)->where('school_id', $this->id)->get();
    }

    public static function aeozeoAdmin($lga_id)
    {
        return Admin::where('is_aeozeo', true)->where('lgas', 'LIKE', '%'.$lga_id.'%')->get();
    }
}
