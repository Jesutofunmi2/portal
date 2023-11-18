<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'school_id',
		'title',
        'wallet_id',
        'description',
        'amount'
    ];

    public function school()
    {
    	return $this->belongsTo('App\Models\School');
    }

    public function getCreatedAtAttribute($date) {
        return Carbon::parse($date)->format('l d, F Y H:ia');
    }
}
