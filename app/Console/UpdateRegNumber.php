<?php
namespace App\Console;

use App\Models\School;
use App\Models\Student\Student;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;


class UpdateRegNumber extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'student:update-regnum';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the regnum of student';

    protected $student;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(StudentRepositoryInterface $student)
    {
        $this->student = $student;

        $students =  Student::where('regnum', 'LIKE', '5%')->get(['id', 'regnum', 'session', 'school_id']);
        $count = $students->count();

       Log::channel('stderr')->info("$count students found");

       $students->each(function($student) {

            $regnum_digit = $this->student->getNextRegNum($student->session, $student->school_id);

            $school = School::find($student->school_id);
            // we add same school to second database, our new app make use of this database 
            $school_lga_id = $school->lga_id > 579 ? $school->lga_id - 569 : $school->lga_id - 568;

            $regnum = str_pad($school_lga_id, 2, "0", STR_PAD_LEFT).substr($student->session, 2, 2).str_pad($student->school_id, 3, "0", STR_PAD_LEFT).str_pad($regnum_digit, 3, "0", STR_PAD_LEFT);

            $student_id = $student->id;
            $student_formal_reg = $student->regnum;

            Log::channel('stderr')->info("student with ID:$student_id and Reg num:$student_formal_reg now have a new reg number: $regnum");

            $regnum_exist = Student::where('regnum', $regnum)->exists();

            if(! $regnum_exist) {
                Log::channel('stderr')->info("new reg number: $regnum does not exist");
                $student->update([
                    'regnum' => $regnum,
                    'regnum_digit' => $regnum_digit
                ]);

                Log::channel('stderr')->info("new reg number: $regnum is updated");
            }
       });
    }
}