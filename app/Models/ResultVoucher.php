<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResultVoucher extends Model
{
	use SoftDeletes;
	
    protected $table = 'result_vouchers';

    protected $fillable = ['pin1', 'pin2', 'pin3', 'pin4', 'pin', 'serial'];

    public static $rules = [
    						'quantity' => 'required|in:10,20,50,100,200,500,1000'
    					];

    public function students(){

    	return $this->belongsTo('App\Models\Student\Student', 'student_id');

    } 
}
