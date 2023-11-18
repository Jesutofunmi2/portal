<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NgStatesLGA extends Model
{
    protected $table = 'lgas';

    public function student(){

    	return $this->hasMany('App\Models\Student\Student', 'lga_id');

    }

     public function teacher(){

    	return $this->hasMany('App\Models\Student\Student', 'lga_id');

    }


    public function states(){

    	return $this->belongsTo('App\ModelsNgStates', 'state_id');

    }

    public function present_lgs_for_display($states_lgsas){
    	$state_LGAS = '';
    	foreach($states_lgsas as $slga){
    	 	 $state_LGAS .= '<div class="item" data-value="'.$slga->id.'">'.$slga->name.'</div>';
    	 }
    	 return $state_LGAS;
    }
}
