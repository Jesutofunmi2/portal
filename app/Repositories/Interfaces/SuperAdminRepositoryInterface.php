<?php 
namespace App\Repositories\Interfaces;

interface SuperAdminRepositoryInterface{

	public function setSuperAdmin();

	public function getAll();

	public function find($id);

} 