<?php 

namespace App\Repositories\Interfaces;

interface LibraryCategoryRepositoryInterface{

	public function setData();

	public function getAll();

	public function find($id);

} 