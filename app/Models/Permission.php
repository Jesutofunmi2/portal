<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Permission extends Model
{
    protected $table = 'permissions';

    protected $fillable = ['admin_id', 'permission_id'];

    public function admins(){

        return $this->belongsToMany('App\Models\School\Admin', 'admin_permission', 'permission_id', 'admin_id');

    }

    public function super_admins(){

        return $this->belongsToMany('App\Models\Ministry\Admin', 'super_admin_permission', 'permission_id', 'super_admin_id');

    }

    public function getPermissionSlugAttribute($value){

    	return Str::slug(trim(preg_replace('!\s+!', ' ', $this->permission)), '-');

    }

    public function teacher_classes(){

        return $this->belongsToMany('App\Models\Teacher\Teacher', 'class_teacher_permission', 'permission_id', 'teacher_id')->withPivot('classarm_id', 'subject_id');

    }
}
