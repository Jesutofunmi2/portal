<?php 

namespace App\Repositories\Interfaces;

interface LibraryIssueRepositoryInterface{

	public function setData();

	public function getAll();

	public function find($id);

} 