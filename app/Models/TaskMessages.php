<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskMessages extends Model
{
    protected $table = 'task_messages';

    protected $fillable = ['task_id', 'commenter_id', 'comment'];
}
