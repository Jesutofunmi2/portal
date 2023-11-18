<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceAnalytic extends Model
{
    protected $table = "attendance_analytics";

    protected $fillable = ['admin_id', 'teacher_id', 'student_id', 'admin_type', 'teacher_type', 'student_type', 'admin_description', 'teacher_description', 'student_description', 'last_seen', 'teacher_date_of_birth', 'teacher_date_of_service', 'teacher_highest_qualification', 'teacher_other_qualification', 'teacher_subject_specialization_major', 'teacher_subject_specialization_minor'];
    
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