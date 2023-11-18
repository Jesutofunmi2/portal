<?php 
namespace App\Repositories\Repo;
use App\Repositories\Interfaces\SuperAdminRepositoryInterface;

use App\Models\Ministry\Admin;

class SuperAdminRepository implements SuperAdminRepositoryInterface{

	public function setSuperAdmin(){
		return new Admin;
	}

	public function getAll(){

		return Admin::all();

	}

	public function find($id){

		return Admin::findOrFail($id);

	}
}