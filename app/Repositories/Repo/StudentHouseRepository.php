<?php 
namespace App\Repositories\Repo;
use App\Repositories\Interfaces\StudentHouseRepositoryInterface;

use App\Models\StudentHouse;

class StudentHouseRepository implements StudentHouseRepositoryInterface{

	public function setSchoolHouse(){
		return new StudentHouse;
	}

	public function getAll(){

		return StudentHouse::all();

	}

	public function find($id){

		return StudentHouse::findOrFail($id);

	}
}