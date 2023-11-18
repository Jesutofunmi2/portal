<?php 

namespace App\Repositories\Repo;
use App\Repositories\Interfaces\TaskRepositoryInterface;

use App\Models\Task;

class TaskRepository implements TaskRepositoryInterface{

	public function setData(){

		return new Task; 
		
	}

	public function getAll(){

		return Task::all();

	}

	public function find($id){

		return Task::findOrFail($id);

	}
}