<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnityCenter extends Model
{
    protected $fillable = [
        'lga_id',
        'name',
        'max_count',
    ];

    public function hall(){
        return $this->hasMany('App\Models\UnityHall', 'unity_centers_id');
    }

    public function ondo_lga(){
        return $this->belongsTo('App\Models\OndoLGA', 'lga_id');
    }

    public function hallAllocation(){
        return $this->hasMany('App\Models\UnityHallAllocation', 'school_center_id');
    }

}