<?php 
namespace App\Repositories\Repo;
use App\Repositories\Interfaces\ResultVoucherRepositoryInterface;

use App\Models\ResultVoucher;

class ResultVoucherRepository implements ResultVoucherRepositoryInterface{

	public function setResultVoucher(){
		return new ResultVoucher;
	}

	public function getAll(){

		return ResultVoucher::all();

	}

	public function find($id){

		return ResultVoucher::findOrFail($id);

	}
}