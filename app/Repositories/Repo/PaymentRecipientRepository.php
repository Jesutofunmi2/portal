<?php 

namespace App\Repositories\Repo;
use App\Repositories\Interfaces\PaymentItemsRepositoryInterface;

use App\Models\PaymentRecipient;

class PaymentRecipientRepository implements PaymentItemsRepositoryInterface{

	public function setData(){

		return new PaymentRecipient; 
		
	}

	public function getAll(){

		return PaymentRecipient::all();

	}

	public function find($id){

		return PaymentRecipient::findOrFail($id);

	}
}