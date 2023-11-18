<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolSurvey extends Model
{
    protected $table = 'school_surveys';
    
    protected $guarded = ['id'];

    protected $casts = [
        'identities' => 'array',
        'characteristic' => 'array',
        'enrollments' => 'array',
        'staffs' => 'array',
        'class_rooms' => 'array',
        'facilities' => 'array',
        'books' => 'array',
        'undertaking' => 'array',
        'checked_by' => 'array',
        'submit_status' => 'boolean',
        'approve_status' => 'boolean'
    ];

    // protected $fillable = ['school_id'];

    public function school(){
    	return $this->belongsTo('App\Models\School');
    }

    

}
