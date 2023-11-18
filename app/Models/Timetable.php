<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    protected $fillable = [
        'school_id',
        'class_id',
        'admin_id'
    ];

    public function period(){
        return $this->hasMany('App\Models\TimetablePeriod', 'timetable_id');
    }
    public function school(){
        return $this->belongsTo('App\Models\School');
    }
    public function admin(){
        return $this->belongsTo('App\Models\School\Admin');
    }
    public function classes(){
        return $this->belongsTo('App\Models\Classes');
    }

    public function deleteAll()
    {
        // delete all related photos 
        $this->period()->delete();
        // as suggested by Dirk in comment,
        // it's an uglier alternative, but faster
        // Photo::where("user_id", $this->id)->delete()

        // delete the user
        return parent::delete();
    }
}