<?php 

namespace App\Repositories\Interfaces;

interface LibraryRepositoryInterface{

	public function setData();

	public function getAll();

	public function find($id);

} 