<?php 
namespace App\Repositories\Repo;
use App\Repositories\Interfaces\TeacherRepositoryInterface;

use App\Models\Teacher\Teacher;
use Session;

class TeacherRepository implements TeacherRepositoryInterface{

	public function setTeacher(){
		return new Teacher;
	}

	public function getAll(){

		return Teacher::all();

	}

	public function find($id){

		return Teacher::findOrFail($id);

	}

	public function getNexStafNum($session, $school_id = 0){

		if($school_id == 0){
			$school = Session::get('admin.school');
		}else{
			$school = $school_id;
		}

		$teacher = Teacher::where('session','=', $session)
						->orderBy('staff_no', 'desc')
						->select('staff_no')
						->first();
			if(!empty($teacher)){	
				$last_id = (int)str_replace(env('STATE_NAME').'/'.str_pad($school, 4, 0, STR_PAD_LEFT).'/STAFF/'.$session.'/', '', $teacher->staff_no);
				return $last_id + 1;
			}else{
				return 1;
			}

	}


	public function getNextStaffDigit($session, $school_id){
						
		$staff_no_digit = Teacher::where('session','=', $session)
						->where('school_id', $school_id)
						->max('staff_no_digit');
											
			if(!empty($staff_no_digit)){
				return $staff_no_digit + 1;
			}else{
				return 1;
			}

	}
	 

	public function checkForDuplicacy($email){
    	
    	$count = Teacher::where('email','=', $email)
                                ->count();

            return $count === 0;
    }

	
}