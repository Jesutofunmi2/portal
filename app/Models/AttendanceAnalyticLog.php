<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceAnalyticLog extends Model
{
    protected $table = "attendance_analytic_logs";

    protected $fillable = ['school_id', 'admin_id', 'teacher_id', 'student_id', 'last_seen'];

    
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