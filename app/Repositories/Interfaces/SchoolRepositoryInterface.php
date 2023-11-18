<?php 
namespace App\Repositories\Interfaces;

interface SchoolRepositoryInterface{

	public function setSchool();

	public function getAll();

	public function find($id);

} 