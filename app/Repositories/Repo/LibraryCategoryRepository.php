<?php 

namespace App\Repositories\Repo;
use App\Repositories\Interfaces\LibraryCategoryRepositoryInterface;
use App\Models\LibraryCategory;

class LibraryCategoryRepository implements LibraryCategoryRepositoryInterface{

	public function setData(){

		return new LibraryCategory; 
		
	}

	public function getAll(){

		return LibraryCategory::all();

	}

	public function find($id){

		return LibraryCategory::findOrFail($id);

	}
}