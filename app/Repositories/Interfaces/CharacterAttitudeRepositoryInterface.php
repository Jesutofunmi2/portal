<?php 
namespace App\Repositories\Interfaces;

interface CharacterAttitudeRepositoryInterface{

	public function setCharacterAttitude();

	public function getAll();

	public function find($id);

	public function checkResultDuplicacy($student_id,$classarm_id,$session,$term);

} 