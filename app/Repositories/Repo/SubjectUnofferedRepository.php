<?php 

namespace App\Repositories\Repo;
use App\Repositories\Interfaces\SubjectUnofferedRepositoryInterface;

use App\Models\SubjectUnoffered;

class SubjectUnofferedRepository implements SubjectUnofferedRepositoryInterface{

	public function setData(){

		return new SubjectUnoffered; 
		
	}

	public function getAll(){

		return SubjectUnoffered::all();

	}

	public function find($id){

		return SubjectUnoffered::findOrFail($id);

	}
}