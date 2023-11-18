<?php 
namespace App\Repositories\Interfaces;

interface PermissionRepositoryInterface{

	public function setPermission();

	public function getAll();

	public function find($id);

} 