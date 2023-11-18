<?php 
namespace App\Repositories\Interfaces;

interface ClassRepositoryInterface{

	public function setClass();

	public function getAll();

	public function find($id);

} 