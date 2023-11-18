<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $table = 'agents';

    protected $fillable = ['fullname', 'access', 'phone', 'email'];

    public static $rules = [
		'fullname' => 'required',
		'email' => 'required|email|unique:agents,email',
		'phone' => 'required|regex:(234?)'

    ];

}
