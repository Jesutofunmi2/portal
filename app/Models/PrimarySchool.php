<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class PrimarySchool extends Authenticatable
{
    protected $table = 'primary_schools';

    protected $fillable = ['name', 'state_id', 'lga_id','address'];

    public static $ruleBatch = [
		'state_id' => 'required|integer',
		'lga_id' => 'required|integer',
		'pseudo_batch_file_name' => ['required','allowexts:xls,xlsx,csv', 'excelFormatAllowed:1']
	];

	public function ondo_lga(){
        return $this->belongsTo('\App\Models\OndoLGA', 'lga_id');
    }

    public function present_schools_for_display($schools){
    	$school_options = '';
    	foreach($schools as $school){
    	 	 $school_options .= '<div class="item" data-value="'.$school->id.'">'.$school->name.'</div>';
    	 }
    	 return $school_options;
    }

    public function voucher(){
    	return $this->hasMany('App\Models\ExamsVouchers', 'school_id');
    }

    public function numberofSlots(){
    	return $this->voucher()->where('regnum', '=', NULL)
    							->where('exam_type', '=', 'entrance')
    							->get()
    							->sum('multiple');
    }

    public function numberOfUsedSlots(){
    	return $this->voucher()->where('regnum', '!=', NULL)
    							->where('exam_type', '=', 'entrance')
    							->count();
    }

    public function numberOfNotUsedSlots(){
    	return $this->numberofSlots() - $this->numberOfUsedSlots();
    }

}
