<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimetablePeriod extends Model
{
    protected $fillable = [
        'timetable_id',
        'time',
        'monday',
        'tuesday',
        'wednesday',
        'thursday',
        'friday'
    ];

    public function timetable(){
        return $this->belongsTo('App\Models\Timetable');
    }
}
