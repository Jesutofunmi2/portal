<?php 
namespace App\Repositories\Interfaces;

interface SubjectRepositoryInterface{
	public function setSubject();
	public function getAll();
	public function find($id);

} 