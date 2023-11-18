<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentIDCard extends Model
{
    protected $table = 'student_idcards';

    protected $fillable = ['student_id','school_id','passport','id_card','exp_date'];

    public function school(){
    	return $this->belongsTo('App\School');
    }

    public function student(){
    	
    	return $this->belongsTo('App\Models\Student\Student');

    }

}
