<?php

namespace App\Exports\Survey;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

class FacilitiesExport implements FromArray, WithTitle, ShouldAutoSize
{
    use Exportable;

    protected $surveys;
    protected $session;

    public function __construct(Collection $surveys, $session)
    {
        $this->surveys = $surveys;
        $this->session = $session;
    }

    public function array(): array
    {
       return [
        ['Census Year', $this->session],
        ['Sector', 'Public'],
        ['Level', 'Contains Nursery and Primary'],
        ['Print Date', Carbon::now()],
        [''],
        [''],
        ['State', 'LGA', 'School Name', 'School Code',
        'Source of Power Supply', 'Source of Water Supply', 'Health Facility',
        'Pit_Student_M', 'Pit_Student_F', 'Pit_Student_B', 'Water_Flush_Student_M', 'Water_Flush_Student_F',
        'Water_Flush_Student_B', 'Bucket_System_Student_M', 'Bucket_System_Student_F', 'Bucket_System_Student_B', 'Pit_Teacher_M',
        'Pit_Teacher_F', 'Pit_Teacher_B', 'Water_Flush_Teacher_M', 'Water_Flush_Teacher_F', 'Water_Flush_Teacher_B',
        'Bucket_System_Teacher_M', 'Bucket_System_Teacher_F', 'Bucket_System_Teacher_B', 'Pit_Mixed_M',
        'Pit_Mixed_F', 'Pit_Mixed_B', 'Water_Flush_Mixed_M', 'Water_Flush_Mixed_F', 'Water_Flush_Mixed_B',
        'Bucket_System_Mixed_M', 'Bucket_System_Mixed_F', 'Bucket_System_Mixed_B'
        ],

        $this->surveys->map(function($survey) {
           $power_source = "";
           $health_facilities = "";

           if($survey->facilities['nepa_power_source']) $power_source .= "NEPA/PHCN: YES ";
           if($survey->facilities['generator_power_source']) $power_source .= "Generator: YES ";
           if($survey->facilities['solar_power_source']) $power_source .= "Solar: YES ";
           if($survey->facilities['no_power_source']) $power_source = "No power source";

           if($survey->facilities['health_clinic']) $health_facilities .= "Health Clinic: YES ";
           if($survey->facilities['first_aid']) $health_facilities .= "First Aid: YES ";
           if($survey->facilities['no_health_facilities']) $health_facilities = "No";

            return [
                'Ondo',
                strtoupper($survey->lga_name),
                strtoupper($survey->name),
                strtoupper($survey->identities['school_code']),
                $power_source, $survey->facilities['source_of_water'], $health_facilities,
                $survey->facilities['pupils_male_pit'], $survey->facilities['pupils_female_pit'],
                $survey->facilities['pupils_mixed_pit'], $survey->facilities['pupils_male_water_flush'],
                $survey->facilities['pupils_female_water_flush'], $survey->facilities['pupils_mixed_water_flush'],
                $survey->facilities['pupils_male_bucket_system'], $survey->facilities['pupils_female_bucket_system'],
                $survey->facilities['pupils_mixed_bucket_system'], $survey->facilities['teachers_male_pit'],
                $survey->facilities['teachers_female_pit'], $survey->facilities['teachers_mixed_pit'],
                $survey->facilities['teachers_male_water_flush'], $survey->facilities['teachers_female_water_flush'], $survey->facilities['teachers_mixed_water_flush'],
                $survey->facilities['teachers_male_bucket_system'], $survey->facilities['teachers_female_bucket_system'], $survey->facilities['teachers_mixed_bucket_system'],
                $survey->facilities['teacher_pupils_male_pit'], $survey->facilities['teacher_pupils_female_pit'], $survey->facilities['teacher_pupils_mixed_pit'],
                $survey->facilities['teacher_pupils_male_water_flush'], $survey->facilities['teacher_pupils_female_water_flush'], $survey->facilities['teacher_pupils_mixed_water_flush'],
                $survey->facilities['teacher_pupils_male_bucket_system'], $survey->facilities['teacher_pupils_female_bucket_system'], $survey->facilities['teacher_pupils_mixed_bucket_system'],
            ];
        })
       ];
    }
    
    /**
     * @return string
     */
    public function title(): string
    {
        return 'Facilities';
    }
}