<?php 

namespace App\Repositories\Repo;
use App\Repositories\Interfaces\PaymentRepositoryInterface;

use App\Models\Payment;

class PaymentRepository implements PaymentRepositoryInterface{

	public function setPayment(){

		return new Payment; 
		
	}

	public function getAll(){

		return Payment::all();

	}

	public function find($id){

		return Payment::findOrFail($id);

	}
}