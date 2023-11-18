<?php 
namespace App\Repositories\Repo;
use App\Repositories\Interfaces\PracticalSkillRepositoryInterface;

use App\Models\PracticalSkill;

class PracticalSkillRepository implements PracticalSkillRepositoryInterface{

	public function setPracticalSkill(){
		return new PracticalSkill;
	}

	public function getAll(){

		return PracticalSkill::all();

	}

	public function find($id){

		return PracticalSkill::findOrFail($id);

	}

	public function checkResultDuplicacy($student_id, $classarm_id,$session,$term){
		$count = PracticalSkill::where('student_id', $student_id)
							->where('classarm_id', $classarm_id)
							->where('session', $session)
							->where('term', $term)
							->count();

		return $count === 0;
	}
}