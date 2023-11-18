<?php 
namespace App\Repositories\Interfaces;

interface ResultVoucherRepositoryInterface{

	public function setResultVoucher();

	public function getAll();

	public function find($id);

} 