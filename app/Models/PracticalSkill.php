<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PracticalSkill extends Model
{
    protected $table = 'practical_skills';

    public function students(){

    	return $this->belongsTo('App\Models\Student\Student', 'student_id');

    } 

    
}
