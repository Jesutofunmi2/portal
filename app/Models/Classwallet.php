<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Classwallet extends Model
{
    // 
    protected $guarded = ['available_balance', 'last_amount'];

    protected $attributes = ['available_balance' => 0,'last_amount' => 0];

    public function classes(): BelongsTo
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }
}
