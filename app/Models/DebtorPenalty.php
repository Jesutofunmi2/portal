<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DebtorPenalty extends Model
{
    protected $table = 'debtor_penalty';

    protected $fillable = ['student_id', 'school_id', 'issue'];

    
}
