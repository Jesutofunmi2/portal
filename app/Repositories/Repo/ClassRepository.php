<?php 
namespace App\Repositories\Repo;
use App\Repositories\Interfaces\ClassRepositoryInterface;

use App\Models\Classes;

class ClassRepository implements ClassRepositoryInterface{

	public function setClass(){
		return new Classes;
	}

	public function getAll(){

		return Classes::all();

	}

	public function find($id){

		return Classes::findOrFail($id);

	}
}