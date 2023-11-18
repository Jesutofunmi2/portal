<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CharacterAttitude extends Model
{
    protected $table = 'character_attitudes';

    public function students(){

    	return $this->belongsTo('App\Models\Student\Student', 'student_id');

    } 
}
