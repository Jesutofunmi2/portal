<?php 

namespace App\Repositories\Interfaces;

interface AdminRepositoryInterface{

	public function setAdmin();

	public function getAll();

	public function find($id);

} 