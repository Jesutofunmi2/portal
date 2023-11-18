<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpecializationSubject extends Model
{
    protected $table = "specialization_subjects";

    protected $fillable = ['subject_name', 'subject_code', 'type'];

}