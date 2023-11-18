<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrafficAnalytic extends Model
{
    protected $table = "traffic_analytics";

    protected $fillable = ['ip', 'last_seen'];
}
