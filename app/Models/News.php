<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
	protected $fillable = [
		'super_admin_id',
		'title',
		'content',
	];

	public function admin(){
    	return $this->belongsTo('App\Models\Ministry\Admin', 'super_admin_id');
    }
}