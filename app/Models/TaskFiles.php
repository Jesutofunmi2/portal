<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskFiles extends Model
{
    protected $table = 'task_files';

    protected $fillable = ['task_id', 'file_upload', 'file_title', 'file_number', 'file_type', 'upload_by'];

}
