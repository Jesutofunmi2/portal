<?php 
namespace App\Repositories\Repo;
use App\Models\School;

use App\Models\Student\Student;

use App\Repositories\Interfaces\StudentRepositoryInterface;

use Illuminate\Support\Facades\Session;

class StudentRepository implements StudentRepositoryInterface{

    public function setStudent(){
        $student = new Student;
        return $student;
    }

    public function getAll(){

        return Student::all();

    }

    public function find($id){

        return Student::findOrFail($id);

    }

    public function getNextRegNum($session, $school_id = 0){

        if($school_id == 0){ 
            abort(400, "school ID not found, please contact admin");
        }
        
        $school = $school_id;

        $regnum_digit = Student::where('session','=', $session)
                        ->where('school_id', $school)
                        ->withTrashed()
                        ->max('regnum_digit');
                        
        if(!empty($regnum_digit)){
            return $regnum_digit + 1;
        }else{
            return 1;
        }

        /*
        $student = Student::where('session','=', $session)
                        ->where('school_id', '=', $school)
                        ->orderBy('id', 'desc')
                        ->select('regnum')
                        ->first();
        if(!empty($student)){   
            $school = School::find($school);
            $session_last_two_digit = substr($session, -2);
            $last_id = (int)str_replace(str_pad($school->lga_id, 2, 0, STR_PAD_LEFT).$session_last_two_digit.str_pad($school->id, 3, 0, STR_PAD_LEFT), '', $student->regnum);
            return $last_id + 1;
        }else{
            return 1;
        }
        */

    }

    public function getRegNumPrefix($session, $school_id = 0){
        if($school_id == 0){
                $school = Session::get('admin.school');
        }else{
                $school = $school_id;
        }
        
        $school = School::find($school);

        // we adjust the lga_id to fit in to the usual regnum format
        $school_lga_id = $school->lga_id > 579 ? $school->lga_id - 569 : $school->lga_id - 568;

        $session_last_two_digit = substr($session, -2);
        return str_pad($school_lga_id, 2, 0, STR_PAD_LEFT).$session_last_two_digit.str_pad($school->id, 3, 0, STR_PAD_LEFT);
    }

    

    public function checkForDuplicacy($parent_phone, $surname, $firstname,$session){
        
        $count = Student::where('parent_phone','=', $parent_phone)
                                ->where('surname','=', $surname)
                                ->where('firstname','=', $firstname)
                                ->where('session','=', $session)
                                ->count();

            return $count === 0;
    }

   

    
}