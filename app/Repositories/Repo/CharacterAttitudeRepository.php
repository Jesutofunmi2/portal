<?php 
namespace App\Repositories\Repo;
use App\Repositories\Interfaces\CharacterAttitudeRepositoryInterface;

use App\Models\CharacterAttitude;

class CharacterAttitudeRepository implements CharacterAttitudeRepositoryInterface{

	public function setCharacterAttitude(){
		return new CharacterAttitude;
	}

	public function getAll(){

		return CharacterAttitude::all();

	}

	public function find($id){

		return CharacterAttitude::findOrFail($id);

	}

	public function checkResultDuplicacy($student_id,$classarm_id,$session,$term){
		$count = CharacterAttitude::where('student_id', $student_id)
							->where('classarm_id', $classarm_id)
							->where('session', $session)
							->where('term', $term)
							->count();

		return $count === 0;
	}
}