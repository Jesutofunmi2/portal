<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $fillable = [
        'cleared_balance',
        'available_balance',
        'last_payment',
        'account_balance',
        'session',
        'school_id'
    ];

    public function school()
    {
    	return $this->hasMany('App\Models\School');
    }
}
