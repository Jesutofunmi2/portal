<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntranceHallAllocation extends Model
{
     protected $table = 'entrance_hall_allocation';

    protected $fillable = ['candidate_id', 'exam_center_lga_id', 'session'];

    public function entrance_exam(){
    	return $this->belongsTo('App\Models\EntranceExam', 'candidate_id');
    }

    public function ondo_lga(){
    	return $this->belongsTo('App\Models\OndoLGA', 'exam_center_lga_id');
    }

    public function center(){
    	return $this->belongsTo('App\Models\AdminEntranceHallAllocation', 'hall_id');
    }
}
