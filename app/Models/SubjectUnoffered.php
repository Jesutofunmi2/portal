<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubjectUnoffered extends Model
{
    protected $table = 'student_subject_unoffered';

    protected $fillable = ['student_id', 'classarm_id', 'subject_id', 'session'];
}
