<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;


class GeneralAccess extends Authenticatable
{
    protected $table = 'general_access';

    protected $fillable = ['surname', 'firstname', 'username', 'email', 'phone', 'type', 'password'];

}
