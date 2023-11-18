<?php 
namespace App\Repositories\Repo;
use App\Repositories\Interfaces\PermissionRepositoryInterface;

use App\Models\Permission;

class PermissionRepository implements PermissionRepositoryInterface{

	public function setPermission(){
		return new Permission;
	}

	public function getAll(){

		return Permission::all();

	}

	public function find($id){

		return Permission::findOrFail($id);

	}
}