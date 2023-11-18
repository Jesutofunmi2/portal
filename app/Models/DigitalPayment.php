<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DigitalPayment extends Model
{
    protected $fillable = [
        'student_id',
        'is_verified',
        'session'
    ];

    public function student(){
        return $this->belongsTo('App\Models\Student\Student');
    }
}