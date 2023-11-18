<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $table = 'transfers';

    protected $fillable = ['student_former_id','student_new_id','student_former_school','student_new_school','former_school_status','new_school_status','session','class_id','classarm_id','term', 'student_status', 'reason_for_transfer', 'debtor_id'];

    public function formerSchool(){
    	return $this->belongsTo('App\Models\School', 'student_former_school');
    }

    public function newSchool(){
    	return $this->belongsTo('App\Models\School', 'student_new_school');
    }

    public function studentBeforeTransfer(){
    	return $this->belongsTo('App\Models\Student', 'student_former_id');
    }

    public function studentAfterTransfer(){
    	return $this->belongsTo('App\Models\Student', 'student_new_id');
    }

    public function debtor(){
    	 return $this->belongsTo('App\Models\DebtorPenalty', 'debtor_id');
    }

    public function classes(){
        return $this->newSchool()->classes();
    }
}
