<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class StudentIDCardRequest extends Model
{
    protected $table = 'student_id_card_requests';

    protected $fillable = ['student_id','school_id','admin_id'];

    public function school(){
    	return $this->belongsTo('App\Models\School');
    }

    public function getCreatedAtAttribute($value) {
        return Carbon::parse($value)->format('l,d M Y | h:m');
    }

    public function getUpdatedAtAttribute($value) {
        return Carbon::parse($value)->format('l,d M Y | h:m');
    }

    public function student(){
    	
    	return $this->belongsTo('App\Models\Student\Student');

    }

    public function admin(){
    	
    	return $this->belongsTo('App\Models\School\Admin');

    }

}
