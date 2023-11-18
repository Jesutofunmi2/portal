<?php 
namespace App\Repositories\Interfaces;

interface StudentHouseRepositoryInterface{

	public function setSchoolHouse();

	public function getAll();

	public function find($id);

} 