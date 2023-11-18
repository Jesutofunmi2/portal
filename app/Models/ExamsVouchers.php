<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamsVouchers extends Model
{
    use SoftDeletes;
	
    protected $table = 'exams_vouchers';

    protected $fillable = ['pin1', 'pin2', 'pin3', 'pin4', 'pin', 'serial', 'multiple', 'exam_type'];

    public static $rules = [
							'quantity' => 'required|in:10,20,50,100,200,500,1000',
    						'exam_type' => 'required|in:unity_exam,jwaec,entrance,pre_waec',
    						'multiple' => 'required|integer'
    					];

   	public function school(){
   		return $this->belongsTo('App\Models\PrimarySchool', 'school_id');
   	}

}
