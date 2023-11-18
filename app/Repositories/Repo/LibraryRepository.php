<?php 

namespace App\Repositories\Repo;
use App\Repositories\Interfaces\LibraryRepositoryInterface;
use App\Models\Library;

class LibraryRepository implements LibraryRepositoryInterface{

	public function setData(){

		return new Library; 
		
	}

	public function getAll(){

		return Library::all();

	}

	public function find($id){

		return Library::findOrFail($id);

	}
}