<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    protected $fillable = [
        'school_id',
        'session',
        'path',
    ];

    public function school()
    {
    	return $this->belongsTo('App\Models\School');
    }

    public function assessmentImage()
    {
    	return $this->hasMany('App\Models\AssessmentImage');
    }
}
