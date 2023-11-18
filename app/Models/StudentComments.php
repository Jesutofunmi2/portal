<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentComments extends Model
{
    protected $table = 'student_comments';

    protected $fillable = [
    	'student_id',
		'comment_house',
		'comment_teacher',
		'comment_guard',
		'comment_principal',
		'session',
		'term',
		'class_id',
		'classarm_id',
		'school_id'
    ];

	public static $ruleForResultUpload = [
		'category' => 'required|integer',
		'class_id' => 'required|integer',
		'session' => 'required|digits:4',
		'classarm_id' => 'required|integer',
		'term' => ['required','regex:/(First|Second|Third)/']
	];
}
