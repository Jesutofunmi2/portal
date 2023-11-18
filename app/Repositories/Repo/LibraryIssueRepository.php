<?php 

namespace App\Repositories\Repo;
use App\Repositories\Interfaces\LibraryIssueRepositoryInterface;
use App\Models\LibraryIssue;

class LibraryIssueRepository implements LibraryIssueRepositoryInterface{

	public function setData(){

		return new LibraryIssue; 
		
	}

	public function getAll(){

		return LibraryIssue::all();

	}

	public function find($id){

		return LibraryIssue::findOrFail($id);

	}
}