<?php 
namespace App\Repositories\Repo;
use App\Repositories\Interfaces\SchoolRepositoryInterface;

use App\Models\School;

class SchoolRepository implements SchoolRepositoryInterface{

	public function setSchool(){
		return new School;
	}

	public function getAll(){

		return School::all();

	}

	public function find($id){

		return School::findOrFail($id);

	}
}