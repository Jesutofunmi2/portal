<?php 
namespace App\Repositories\Repo;
use App\Repositories\Interfaces\StudentResultRepositoryInterface;

use App\Models\StudentResult;

class StudentResultRepository implements StudentResultRepositoryInterface{

	public function setStudentResult(){
		return new StudentResult;
	}

	public function getAll(){

		return StudentResult::all();

	}

	public function find($id){

		return StudentResult::findOrFail($id);

	}

	public function checkResultDuplicacy($student_id, $subject_id,$classarm_id,$session,$term){
		$count = StudentResult::where('student_id', $student_id)
							->where('subject_id', $subject_id)
							->where('classarm_id', $classarm_id)
							->where('session', $session)
							->where('term', $term)
							->count();

		return $count === 0;
	}

	public function getResultDuplicacyId($student_id, $subject_id,$school_id,$classarm_id,$session,$term){
		$data = StudentResult::where('student_id', $student_id)
							->where('subject_id', $subject_id)
							->where('classarm_id', $classarm_id)
							->where('session', $session)
							->where('term', $term)
							->first();

		return $data;
	}
}