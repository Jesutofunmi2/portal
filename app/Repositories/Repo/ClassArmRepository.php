<?php 
namespace App\Repositories\Repo;
use App\Repositories\Interfaces\ClassArmRepositoryInterface;

use App\Models\ClassArms;

class ClassArmRepository implements ClassArmRepositoryInterface{

	public function setClassArms(){

		return new ClassArms; 
		
	}

	public function getAll(){

		return ClassArms::all();

	}

	public function find($id){

		return ClassArms::findOrFail($id);

	}
}