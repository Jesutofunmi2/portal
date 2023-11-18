<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubjectAttendanceAnalyticLog extends Model
{
    protected $table = "subject_attendance_analytic_logs";

    protected $fillable = ['school_id', 'subject_id', 'teacher_id', 'student_id', 'session', 'term', 'last_seen'];

    
    public function school(){
        return $this->belongsTo('App\Models\School', 'school_id');
    }
    
    public function subject(){
        return $this->belongsTo('App\Models\Subject', 'subject_id');
    }

    public function teacher(){
        return $this->belongsTo('App\Models\Teacher\Teacher', 'teacher_id');
    }

    public function student(){
        return $this->belongsTo('App\Models\Student\Student', 'student_id');
    }

}