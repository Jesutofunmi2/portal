<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Classes extends Model
{
    protected $table = 'classes';

    protected $fillable = ['class_name', 'school_id'];

    public static $rules = [
    	'class_name' => 'required'
    ];

    public function present_classes_for_display($classes){
        $classes_options = '';
        foreach($classes as $class){
             $classes_options .= '<div class="item" data-value="'.$class->id.'">'.$class->class_name.'</div>';
         }
         return $classes_options;
    }

    public function class_arms(){

    	return $this->hasMany('App\Models\ClassArms', 'class_id');

    }

    public function student(){

    	return $this->hasMany('App\Models\Student\Student', 'class_id');

    }

    public function classWallet(): HasOne
    {
       return $this->hasOne(Classwallet::class, 'class_id');
    }

    
}
