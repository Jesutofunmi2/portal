<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnityHall extends Model
{
    protected $fillable = [
        'unity_centers_id',
        'name',
        'max_count'
    ];

    public function center(){
        return $this->belongsTo('App\Models\UnityCenter', 'unity_centers_id');
    }
}