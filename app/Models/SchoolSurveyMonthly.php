<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolSurveyMonthly extends Model
{
    protected $table = 'school_surveys_monthly';
    
    protected $guarded = ['id'];

    // protected $fillable = ['school_id'];

    public function school(){
    	return $this->belongsTo('App\Models\School');
    }

    

}
