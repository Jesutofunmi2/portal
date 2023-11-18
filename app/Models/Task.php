<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tasks';

    public static $rules = [
        'title' => 'required',
        'start_date' => 'required',
        'due_date' => 'required',
        'department_id' => 'required',
        'descrip' => 'required',
    ];

    protected $fillable = ['title', 'department_id', 'start_date', 'due_date', 'descrip', 'task_status', 'approval', 'posted_by'];

    public function super_admins(){
        return $this->belongsToMany('App\Models\Ministry\Admin', 'tasks_members', 'task_id', 'super_admin_id');
    }

    public function department(){
        return $this->belongsTo('App\Models\MinistryDepartment', 'department_id');
    }
}
