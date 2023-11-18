<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentHouse extends Model
{
    protected $table = 'student_houses';

    protected $fillable = ['name', 'school_id'];

    public static $rule = [
    	'school_house' => 'required|school_house_check',
    ];

    public function students(){
    	return $this->hasMany('App\Models\Student\Student', 'house_id');
    }

    public function teachers(){
    	return $this->hasMany('App\Models\Teacher\Teacher', 'house_id');
    }

     public function house_masters(){

        return $this->belongsToMany('App\Models\Teacher\Teacher', 'house_house_master', 'house_id', 'teacher_id')->withPivot('school_id','session');

    }


}
