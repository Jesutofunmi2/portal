<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnityHallAllocation extends Model
{
    protected $table = 'umity_hall_allocation';

    protected $fillable = ['candidate_id', 'exam_center_lga_id', 'session', 'school_center_id'];

    public function unity_exam(){
    	return $this->belongsTo('App\Models\UnityExam', 'candidate_id');
    }

    public function ondo_lga(){
    	return $this->belongsTo('App\Models\OndoLGA', 'exam_center_lga_id');
    }

    public function center(){
    	return $this->belongsTo('App\Models\AdminUnityHallAllocation', 'hall_id');
    }
}
