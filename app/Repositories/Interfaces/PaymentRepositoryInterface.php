<?php 

namespace App\Repositories\Interfaces;

interface PaymentRepositoryInterface{

	public function setPayment();

	public function getAll();

	public function find($id);

} 