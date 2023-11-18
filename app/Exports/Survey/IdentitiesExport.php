<?php

namespace App\Exports\Survey;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class IdentitiesExport implements FromArray, WithTitle, ShouldAutoSize
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
        ['School Level', 'State', 'LGA', 'School Name', 'School Code', 'Public/Private', 'Project', 'Reported in Census',
        'School Mapped', 'XCoordinate', 'YCoordinate'],
        $this->surveys->map(function($survey) {
            return [
                'Pre-Primary and Primary',
                'Ondo',
                strtoupper($survey->lga_name),
                strtoupper($survey->name),
                strtoupper($survey->identities['school_code']),
                'Public', '', 'No', 'No', $survey->identities['school_lat'],
                $survey->identities['school_long']
            ];
        })
       ];
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

    // public function headings(): array
    // {
    //     $heading = ['surname', 'firstname', 'middlename', 'regnum'];
        
    //     // foreach ($this->data['subject_codes'] as $temp_code) {
    //     //     $code = str_replace('-', '_', $temp_code);
    //     //     $heading[] = 'ca1_'.strtolower($code);
    //     //     $heading[] = 'ca2_'.strtolower($code);
    //     //     $heading[] = 'exam_'.strtolower($code);
    //     // }

    //     return $heading;
    // }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'General';
    }
}