<?php 
namespace App\Repositories\Interfaces;

interface PracticalSkillRepositoryInterface{

	public function setPracticalSkill();

	public function getAll();

	public function find($id);

	public function checkResultDuplicacy($student_id, $classarm_id,$session,$term);

} 