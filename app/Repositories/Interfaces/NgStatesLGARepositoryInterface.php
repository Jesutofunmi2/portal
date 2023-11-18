<?php 
namespace App\Repositories\Interfaces;

interface NgStatesLGARepositoryInterface{

	public function setNgStatesLGA();

	public function getAll();

	public function find($id);
	
	public function findWithStateId($id);

} 