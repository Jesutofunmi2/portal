<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $table = 'subjects';

    protected $fillable = ['subject_name', 'subject_code','class_category', 'subject_category'];

    public static $rules = [
		'subject_name' => 'required',
		'subject_code' => 'required',
        'class_category' => ['required','regex:/(JSS|SSS)/']
	];
    public static $ruleBatch = [
        'pseudo_batch_file_name' => ['required','allowexts:xls,xlsx,csv', 'excelFormatAllowed:3']
    ];

    public function present_subjects_for_display($subjects){
        $subject_options = '<option value=""> Select Subjects Area</option>';
        foreach($subjects as $subject){
             $subject_options .= '<option  value="'.$subject->id.'" 
              >'.$subject->subject_name.'('.$subject->class_category.')</option>';
         }
         return $subject_options;
    }

    public function students() {
        return $this->belongsToMany('App\Models\Student\Student', 'student_subject_unoffered', 'subject_id', 'student_id')->withPivot('session', 'classarm_id');
    }

    /*public function teachers(){
    	return $this->belongsToMany('App\Teacher', 'subject_teacher', 'subject_id', 'teacher_id')->withPivot('school_id');
    }*/
    

    public function teachers($school_id){
      return $this->belongsToMany('App\Models\Teacher\Teacher', 'subject_teacher', 'subject_id', 'teacher_id')->wherePivot('school_id', $school_id);
    }

    public function teachersNew(){
        return $this->belongsToMany('App\Models\Teacher\Teacher', 'subject_teacher', 'subject_id', 'teacher_id')->wherePivot('school_id');
    }

    public function classarms(){

    	return $this->belongsToMany('App\Models\ClassArms', 'classarm_subject', 'subject_id', 'classarm_id')->withPivot('teacher_id', 'session');

    }

    public function subjectResults() {

        return $this->hasMany('App\Models\StudentResult', 'subject_id');

    }

    public function present_teachers_for_display($subject_id, $teachers){

        $output = new \stdClass;

        $teacher_select_option  = '<option>Select multiple Teachers</option>';
        $teacher_div_option = '<div class="item" data-value="">Select multiple Teachers</div>';

         foreach($teachers as $teacher){
           $teacher_select_option .= '<option  value="'.$teacher->id.'">'.$teacher->surname .' '. $teacher->firstname.' '.$teacher->middlename.'</option>';
           $teacher_div_option .= '<div class="item" data-value="'.$teacher->id.'">'.$teacher->surname .' '. $teacher->firstname.' '.$teacher->middlename.'</div>';
         }

        $output->teacher_div_option = $teacher_div_option;

        $output->teacher_display = $teacher_select_option;

        $output->select_name = 'subject_teachers['.$subject_id.'][]'; 

    return $output;
        
    }
}
