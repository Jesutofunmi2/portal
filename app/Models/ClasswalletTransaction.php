<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ClasswalletTransaction extends Model
{
    //
    protected $guarded = [];

    public function getCreatedAtAttribute($date) {
        return Carbon::parse($date)->format('l d, F Y H:ia');
    }
}
