<?php 
namespace App\Repositories\Repo;
use App\Repositories\Interfaces\NgStatesRepositoryInterface;
use App\Models\NgStates;

class NgStatesRepository implements NgStatesRepositoryInterface{

	public function setNgStates(){
		return new NgStates;
	}

	public function getAll($filter){

		return NgStates::all($filter);

	}

	public function find($id){

		return NgStates::findOrFail($id);

	}
}