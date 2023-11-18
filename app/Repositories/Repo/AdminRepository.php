<?php 
namespace App\Repositories\Repo;
use App\Repositories\Interfaces\AdminRepositoryInterface;

use App\Models\School\Admin;

class AdminRepository implements AdminRepositoryInterface{


	public function setAdmin(){
		return new Admin;
	}

	public function getAll(){

		return Admin::all();

	}

	public function find($id){

		return Admin::findOrFail($id);

	}
}