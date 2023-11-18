<?php 
namespace App\Repositories\Interfaces;

interface StudentRepositoryInterface{

	public function setStudent();

	public function getAll();

	public function find($id);
	
	public function getNextRegNum($session, $student_id);

	public function getRegNumPrefix($session, $student_id);

	public function checkForDuplicacy($parent_email, $surname, $firstname,$session);

} 