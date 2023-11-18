<?php 
namespace App\Repositories\Interfaces;

interface StudentCommentsRepositoryInterface{

	public function setStudentComments();

	public function getAll();

	public function find($id);
	
	public function checkCommentDuplicacy($student_id, $school_id,$classarm_id,$session,$term);
	
	public function getCommentDuplicacyId($student_id, $school_id,$classarm_id,$session,$term);
} 