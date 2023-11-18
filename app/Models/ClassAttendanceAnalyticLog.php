<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ClassAttendanceAnalyticLog extends Model
{
    protected $table = "class_attendance_analytic_logs";

    protected $fillable = ['school_id', 'class_id', 'teacher_id', 'student_id', 'session', 'term', 'last_seen'];
    
    public function classes(){
        return $this->belongsTo('App\Classes', 'class_id');
    }
    
    public function school(){
        return $this->belongsTo('App\Models\School', 'school_id');
    }
    
    public function admin(){
        return $this->belongsTo('App\Models\School\Admin', 'admin_id');
    }

    public function teacher(){
        return $this->belongsTo('App\Models\Teacher\Teacher', 'teacher_id');
    }

    public function student(){
        return $this->belongsTo('App\Models\Student\Student', 'student_id');
    }

}