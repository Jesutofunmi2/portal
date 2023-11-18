<?php 
namespace App\Repositories\Repo;
use App\Repositories\Interfaces\DebtorPenaltyRepositoryInterface;

use App\Models\DebtorPenalty;

class DebtorPenaltyRepository implements DebtorPenaltyRepositoryInterface{

	public function setDebtor(){
		return new DebtorPenalty;
	}

	public function getAll(){

		return DebtorPenalty::all();

	}

	public function find($id){

		return DebtorPenalty::findOrFail($id);

	}
}