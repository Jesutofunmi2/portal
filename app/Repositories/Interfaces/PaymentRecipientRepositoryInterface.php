<?php 

namespace App\Repositories\Interfaces;

interface PaymentRecipientRepositoryInterface{

	public function setData();

	public function getAll();

	public function find($id);

} 