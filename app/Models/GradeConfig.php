<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GradeConfig extends Model
{
    protected $table = 'grade_config';

    protected $fillable = ['school_id', 'class_id', 'grade_id', 'score_from', 'score_to'];

}
