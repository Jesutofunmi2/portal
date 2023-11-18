<?php 
namespace App\Repositories\Repo;
use App\Repositories\Interfaces\SubjectRepositoryInterface;

use App\Models\Subject;

class SubjectRepository implements SubjectRepositoryInterface{

	public function setSubject(){

		$subject =  new Subject;

		return $subject;
		
	}

	public function getAll(){

		return Subject::all();

	}

	public function find($id){

		return Subject::findOrFail($id);

	}
}