<?php 
namespace App\Repositories\Repo;
use App\Repositories\Interfaces\StudentCommentsRepositoryInterface;

use App\Models\StudentComments;

class StudentCommentsRepository implements StudentCommentsRepositoryInterface{

	public function setStudentComments(){
		return new StudentComments;
	}

	public function getAll(){

		return StudentComments::all();

	}

	public function find($id){

		return StudentComments::findOrFail($id);

	}

	public function checkCommentDuplicacy($student_id,$school_id,$classarm_id,$session,$term){
		$count = StudentComments::where('student_id', $student_id)
							->where('school_id', $school_id)
							->where('classarm_id', $classarm_id)
							->where('session', $session)
							->where('term', $term)
							->count();

		return $count === 0;
	}

	public function getCommentDuplicacyId($student_id,$school_id,$classarm_id,$session,$term){
		$data = StudentComments::where('student_id', $student_id)
							->where('school_id', $school_id)
							->where('classarm_id', $classarm_id)
							->where('session', $session)
							->where('term', $term)
							->first();

		return $data;
	}
}