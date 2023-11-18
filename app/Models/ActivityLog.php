<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $table = "activity_logs";

    protected $fillable = ['super_admin_id', 'school_id', 'admin_id', 'teacher_id', 'student_id', 'message', 'path', 'type', 'ip', 'device'];

    
    public function superAdmin(){
        return $this->belongsTo('App\Models\Ministry\Admin', 'super_admin_id');
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

    public function getCreatedAtAttribute($date)
    {
        $date = Carbon::parse($date); // now date is a carbon instance
        return $date->diffForHumans();
    }

    public function getUpdateAtAttribute($date) {
        return Carbon::parse($date)->format('l d, F Y H:ia');
    }

}