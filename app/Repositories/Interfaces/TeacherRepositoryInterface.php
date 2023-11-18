<?php 
namespace App\Repositories\Interfaces;

interface TeacherRepositoryInterface{

	public function setTeacher();
	public function getAll();
	public function find($id);
	public function getNexStafNum($session, $school_id);
	public function getNextStaffDigit($session, $school_id);
	public function checkForDuplicacy($email);

} 