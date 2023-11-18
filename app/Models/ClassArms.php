<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassArms extends Model
{
    protected $table = 'class_arms';

    protected $fillable = ['class_id', 'class_arm', 'school_id'];

    public static $rules = [
        'class_id' => 'required|integer',
        'class_arm_name' => 'required'
    ];

    public static $ruleAssign = [
        'class_id' => 'required|integer',
        'class_arm_id' => 'required|integer',
        'subjects' => 'required|array|min:1'
    ];

    public static $ruleTeacherAssign = [
        'class_id' => 'required|integer',
        'class_arm_id' => 'required|integer',
        'teachers' => 'required|array|min:1'
    ];

    public function classes(){

    	return $this->belongsTo('App\Models\Classes', 'class_id');

    }

    public function student(){
    	return $this->hasMany('App\Models\Student\Student', 'class_arm_id');
    }

    public function present_class_arm_for_display($class_arms){
    	$class_ARMS = '';
    	foreach($class_arms as $arm){
    	 	 $class_ARMS .= '<div class="item" data-value="'.$arm->id.'">'.$arm->class_arm.'</div>';
    	 }
    	 return $class_ARMS;
    }

    public function subjects(){

        return $this->belongsToMany('App\Models\Subject', 'classarm_subject', 'classarm_id', 'subject_id')->withPivot('teacher_id', 'session');

    }

    public function teachers(){

        return $this->belongsToMany('App\Models\Teacher\Teacher', 'classarm_teacher', 'classarm_id')->withPivot('session');

    }

    public function counsellors(){

        return $this->belongsToMany('App\Models\Teacher\Teacher', 'classarm_counsellor', 'classarm_id')->withPivot('session');

    }

    public function students(){

        return $this->belongsToMany('App\Models\Student\Student', 'classarm_student', 'classarm_id')->withPivot('session', 'term','class_id');

    }


}
