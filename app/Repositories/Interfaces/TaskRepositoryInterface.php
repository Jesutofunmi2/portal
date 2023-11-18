<?php 

namespace App\Repositories\Interfaces;

interface TaskRepositoryInterface{

	public function setData();

	public function getAll();

	public function find($id);

} 