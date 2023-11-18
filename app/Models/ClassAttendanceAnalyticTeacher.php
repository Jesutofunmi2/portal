<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassAttendanceAnalyticTeacher extends Model
{
    protected $table = "class_attendance_analytic_teachers";

    protected $fillable = ['school_id', 'class_id', 'teacher_id', 'class_arm_id'];

    
    public function school(){
        return $this->belongsTo('App\Models\School', 'school_id');
    }
    
    public function classes(){
        return $this->belongsTo('App\Models\Classes', 'class_id');
    }
    
    public function classArm(){
        return $this->belongsTo('App\Models\ClassArms', 'class_arm_id');
    }

    public function teacher(){
        return $this->belongsTo('App\Models\Teacher\Teacher', 'teacher_id');
    }

}