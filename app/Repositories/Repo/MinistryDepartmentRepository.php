<?php 

namespace App\Repositories\Repo;
use App\Repositories\Interfaces\MinistryDepartmentRepositoryInterface;

use App\Models\MinistryDepartment;

class MinistryDepartmentRepository implements MinistryDepartmentRepositoryInterface{

	public function setData(){

		return new MinistryDepartment; 
		
	}

	public function getAll(){

		return MinistryDepartment::all();

	}

	public function find($id){

		return MinistryDepartment::findOrFail($id);

	}
}