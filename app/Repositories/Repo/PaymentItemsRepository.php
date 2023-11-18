<?php 

namespace App\Repositories\Repo;
use App\Repositories\Interfaces\PaymentItemsRepositoryInterface;

use App\Models\PaymentItems;

class PaymentItemsRepository implements PaymentItemsRepositoryInterface{

	public function setData(){

		return new PaymentItems; 
		
	}

	public function getAll(){

		return PaymentItems::all();

	}

	public function find($id){

		return PaymentItems::findOrFail($id);

	}
}