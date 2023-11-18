<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NgStates extends Model
{
    protected $table = 'states';


    public function student(){

    	return $this->hasMany('App\Models\Student\Student', 'state_id');

    }

    public function teacher(){

    	return $this->hasMany('App\Models\Student\Student', 'state_id');

    }

    public function lga(){

    	return $this->hasMany('App\Models\NgStatesLGA', 'state_id');

    }

    public function ondo_lga(){

        return $this->hasMany('App\Models\OndoLGA', 'state_id');

    }

}
