<?php 
namespace App\Repositories\Repo;
use App\Repositories\Interfaces\NgStatesLGARepositoryInterface;

use App\Models\NgStatesLGA;

class NgStatesLGARepository implements NgStatesLGARepositoryInterface{

	public function setNgStatesLGA(){
		return new NgStatesLGA;
	}

	public function getAll(){

		return NgStatesLGA::all();

	}

	public function find($id){

		return NgStatesLGA::findOrFail($id);

	}

	public function findWithStateId($id){

		return NgStatesLGA::where('state_id',$id)->get();

	}
}