<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentResult extends Model
{
    use SoftDeletes;
    
    protected $table = 'student_results';

    protected $fillable = [
    	'student_id',
		'subject_id',
		'ca_score',
		'ca2_score',
		'exam_score',
		'weighted_average',
		'grade',
		'remarks',
		'status',
		'session',
		'term',
		'class_id',
		'classarm_id',
		'school_id'
    ];

    public static $ruleForSubjects = [
		'class_id' => 'required|integer',
		'session' => 'required|digits:4',
		'class_arm_id' => 'required|integer',
		'term' => ['required','regex:/(First|Second|Third)/']
	];

	public static $ruleForResultUpdate = [
		'class_id' => 'required|integer',
		'session' => 'required|digits:4',
		'classarm_id' => 'required|integer',
		'term' => ['required','regex:/(First|Second|Third)/'],
		'ca' => 'required|array',
		'exam' => 'required|array',
		'subject_id' => 'required|array',
		'student_id' => 'required|integer',
	];

    public function student() {

    	return $this->belongsTo('App\Models\Student\Student', 'student_id');

	}  
	
	public function subject() {

    	return $this->belongsTo('App\Models\Subject', 'subject_id');

    }  

}
