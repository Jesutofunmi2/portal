<?php 
namespace App\Repositories\Interfaces;

interface DebtorPenaltyRepositoryInterface{

	public function setDebtor();

	public function getAll();

	public function find($id);

} 