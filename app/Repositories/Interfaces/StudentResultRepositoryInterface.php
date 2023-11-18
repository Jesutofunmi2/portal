<?php 
namespace App\Repositories\Interfaces;

interface StudentResultRepositoryInterface{

	public function setStudentResult();

	public function getAll();

	public function find($id);
	
	public function checkResultDuplicacy($regnum, $subject_id,$classarm_id,$session,$term);
	
	public function getResultDuplicacyId($regnum, $subject_id,$school_id,$classarm_id,$session,$term);
} 