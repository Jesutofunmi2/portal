<?php

namespace App\Exports\Survey;

use App\Models\SchoolSurvey;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ClassroomsExport implements FromArray, WithTitle, ShouldAutoSize
{
    use Exportable;

    protected $surveys;
    protected $lgas;
    protected $session;
    protected $headings = ['State', 'LGA', 'School', 'Two Shift Schools', 'Total Rooms',
                            'Rooms In Good Condition', 'Rooms Need Minor Repairs', 'Rooms Need Major Repairs',
                            'Rooms UnderConstruction', 'Number of Unusable Rooms', 'Have Seating',
                            'Have Good Blackboard', 'PCR', 'Additional ClassRooms'];
    public $lga_summary = [];
    
    public $two_shift_schools = 0;
    public $total_rooms = 0;
    public $rooms_in_good_condition = 0;
    public $rooms_in_need_minor_repair = 0;
    public $rooms_in_need_major_repair = 0;
    public $rooms_under_construction = 0;
    public $rooms_unstable = 0;
    public $have_seatings = 0;
    public $have_blackboard = 0;
    public $pcr = 0;
    public $additional_classrooms = 0;

    public function __construct(Collection $surveys, Collection $lgas, $session)
    {
        $this->surveys = $surveys;
        $this->lgas = $lgas;
        $this->session = $session;
    }

    public function array(): array
    {
        $all = [
            ['Census Year', $this->session],
            ['Sector', 'Public'],
            ['Level', 'Contains Nursery and Primary'],
            ['Print Date', Carbon::now()],
            [''],
        ];

        $this->lgas->map(function($lga) use (&$all) {
            $surveys = $this->surveys->filter(function($survey) use ($lga) {return $survey->lga_id == $lga->id;})->all();
            $lga_name = strtoupper($lga->name);
            array_push($all, ['LGA: '.$lga_name]);
            array_push($all, $this->headings);

            $data = collect($surveys)->map(function($survey) use ($lga_name) {
                return $this->getTeacherSurveyData($survey, $lga_name);
            });
            array_push($all, ...$data);
            array_push($all, ['', '', 'TOTAL', $this->two_shift_schools, $this->total_rooms, $this->rooms_in_good_condition,
            $this->rooms_in_need_minor_repair, $this->rooms_in_need_major_repair, $this->rooms_under_construction, $this->rooms_unstable,
            $this->have_seatings, $this->have_blackboard, $this->pcr, $this->additional_classrooms]);
            array_push($all, ['']);
            array_push($all, ['']);
            array_push($this->lga_summary, ['', '', $lga_name, $this->two_shift_schools, $this->total_rooms, $this->rooms_in_good_condition,
            $this->rooms_in_need_minor_repair, $this->rooms_in_need_major_repair, $this->rooms_under_construction, $this->rooms_unstable,
            $this->have_seatings, $this->have_blackboard, $this->pcr, $this->additional_classrooms]);

            $this->two_shift_schools = 0;
            $this->total_rooms = 0;
            $this->rooms_in_good_condition = 0;
            $this->rooms_in_need_minor_repair = 0;
            $this->rooms_in_need_major_repair = 0;
            $this->rooms_under_construction = 0;
            $this->rooms_unstable = 0;
            $this->have_seatings = 0;
            $this->have_blackboard = 0;
            $this->pcr = 0;
            $this->additional_classrooms = 0;
        });

        array_push($all, ...$this->lga_summary);
        
       return $all;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            6    => ['font' => ['bold' => true]],

            // // Styling a specific cell by coordinate.
            // 'B2' => ['font' => ['italic' => true]],

            // // Styling an entire column.
            // 'C'  => ['font' => ['size' => 16]],
        ];
    }

    public function getTeacherSurveyData(SchoolSurvey $survey, $lga_name)
    {
        $two_shift_schools = 0;
        $total_rooms = $survey->class_rooms['school_classrooms'];
        $rooms_in_good_condition = 0;
        $rooms_in_need_minor_repair = 0;
        $rooms_in_need_major_repair = 0;
        $rooms_under_construction = 0;
        $rooms_unstable = 0;
        $have_seatings = 0;
        $have_blackboard = 0;
        $pcr = 0;
        $additional_classrooms =  $survey->class_rooms['others_room'];

        $classrooms = $survey->class_rooms['classrooms_data'];

        foreach ($classrooms as $classroom) {
            if($classroom['present_condition'] == 'Good') $rooms_in_good_condition += 1;
            if($classroom['present_condition'] == 'Needs Minor Repairs') $rooms_in_need_minor_repair += 1;
            if($classroom['present_condition'] == 'Needs Major Repairs') $rooms_in_need_major_repair += 1;
            if($classroom['present_condition'] == 'Under Construction') $rooms_under_construction += 1;
            if($classroom['present_condition'] == 'Unusable') $rooms_unstable += 1;
            if($classroom['seating'] == 'Yes') $have_seatings += 1;
            if($classroom['writing_board'] == 'Yes') $have_blackboard += 1;
        }
        
        $this->two_shift_schools += $two_shift_schools;
        $this->total_rooms += $total_rooms;
        $this->rooms_in_good_condition +=  $rooms_in_good_condition;
        $this->rooms_in_need_minor_repair += $rooms_in_need_minor_repair;
        $this->rooms_in_need_major_repair += $rooms_in_need_major_repair;
        $this->rooms_under_construction += $rooms_under_construction;
        $this->rooms_unstable += $rooms_unstable;
        $this->have_seatings += $have_seatings;
        $this->have_blackboard += $have_blackboard;
        $this->pcr += $pcr;
        $this->additional_classrooms += $additional_classrooms;

        return ['Ondo', $lga_name,
            strtoupper($survey->name),
            $two_shift_schools, $total_rooms, $rooms_in_good_condition, $rooms_in_need_minor_repair,
            $rooms_in_need_major_repair, $rooms_under_construction, $rooms_unstable, $have_seatings,
            $have_blackboard, $pcr, $additional_classrooms
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Classrooms';
    }
}