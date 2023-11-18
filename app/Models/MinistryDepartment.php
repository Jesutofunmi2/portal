<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MinistryDepartment extends Model
{
    protected $table = 'ministry_department';

    protected $fillable = ['name'];

    public static $rules = [
        'name' => 'required|string|unique:ministry_department,name'
    ];

    public function super_admins(){
        return $this->hasMany('\App\Models\Ministry\Admin', 'department_id');
    }

    public function task(){
        return $this->hasMany('\App\Models\Task', 'department_id');
    }
}
