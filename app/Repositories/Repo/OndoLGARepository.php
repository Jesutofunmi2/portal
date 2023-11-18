<?php 
namespace App\Repositories\Repo;
use App\Repositories\Interfaces\OndoLGARepositoryInterface;

use App\Models\OndoLGA;

class OndoLGARepository implements OndoLGARepositoryInterface{

	public function setOndoLGA(){
		return new OndoLGA;
	}

	public function getAll(){

		return OndoLGA::all();

	}

	public function find($id){

		return OndoLGA::findOrFail($id);

	}
}