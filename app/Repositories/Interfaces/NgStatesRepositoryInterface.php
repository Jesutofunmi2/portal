<?php 
namespace App\Repositories\Interfaces;

interface NgStatesRepositoryInterface{

	public function setNgStates();

	public function getAll($filter);

	public function find($id);

} 