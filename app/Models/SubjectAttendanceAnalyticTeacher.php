<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Model;

class SubjectAttendanceAnalyticTeacher extends Model
{
    protected $table = "subject_attendance_analytic_teachers";

    protected $fillable = ['school_id', 'subject_id', 'teacher_id', 'class_id', 'class_arm_id'];

    
    public function school(){
        return $this->belongsTo('App\Models\School', 'school_id');
    }
    
    public function subject(){
        return $this->belongsTo('App\Models\Subject', 'subject_id');
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