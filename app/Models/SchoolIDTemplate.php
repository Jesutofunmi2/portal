<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolIDTemplate extends Model
{
    protected $table = 'school_id_template';

    protected $fillable = ['school_id','school_id_logo','school_id_design', 'exp_date'];

    public function school(){
    	return $this->belongsTo('App\Models\School');
    }

    

}
