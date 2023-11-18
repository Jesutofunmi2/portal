<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentImage extends Model
{
    protected $fillable = [
        'assessment_id',
        'path'
    ];

    public function assessment()
    {
    	return $this->belongsTo('App\Models\Assessment');
    }
}
