<?php

namespace App\Http\Helper;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithProperties;


class StudentExcelExport implements FromArray,
                                    WithHeadings,
                                    ShouldAutoSize,
                                    WithStyles,
                                    WithProperties
{
    protected $data;
    protected $msg;

    public function __construct(array $data, ?string $msg = null)
    {
        $this->data = $data;
        $this->msg = $msg;
    }

    public function array(): array
    {
        return $this->data;
    }
    public function headings(): array
    {
        return [
            ['Digi-Realm I.T Solution'],
            ['LEARNERS ENROLMENT IN PUBLIC SENIOR SECONDARY SCHOOLS IN ONDO STATE BY GENDER/STREAM'],
            [$this->msg],
            [],
            ['SCHOOL NAME / L.G.A ','JSS 1','','','', 'JSS 2','','','', 'JSS 3','','','', 'SSS 1','','','', 'SSS 2','','','', 'SSS 3','','',''],
            ['','MALE','FEMALE','UNKNOWN','TOTAL','MALE','FEMALE','UNKNOWN','TOTAL','MALE','FEMALE','UNKNOWN','TOTAL','MALE','FEMALE','UNKNOWN','TOTAL','MALE','FEMALE','UNKNOWN','TOTAL','MALE','FEMALE','UNKNOWN','TOTAL','','TOTAL_MALE','TOTAL_FEMALE','TOTAL_UNKNOWN','OVERALL TOTAL'],
         ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
            2    => ['font' => ['bold' => true]],
            3    => ['font' => ['bold' => true]],
            5    => ['font' => ['bold' => true]],

            // Styling a specific cell by coordinate.
            //'B2' => ['font' => ['italic' => true]],

            // Styling an entire column.
            'E'  => ['font' => ['size' => 13, 'bold' => true ]],
            'I'  => ['font' => ['size' => 13, 'bold' => true ]],
            'M'  => ['font' => ['size' => 13, 'bold' => true ]],
            'Q'  => ['font' => ['size' => 13, 'bold' => true ]],
            'U'  => ['font' => ['size' => 13, 'bold' => true ]],
            'Y'  => ['font' => ['size' => 13, 'bold' => true ]],
            'Z'  => ['font' => ['size' => 13, 'bold' => true , 'width' => 15]],
            'AA'  => ['font' => ['size' => 13, 'bold' => true ]],
            'AB'  => ['font' => ['size' => 13, 'bold' => true ]],
            'AC'  => ['font' => ['size' => 13, 'bold' => true ]],
            'AD'  => ['font' => ['size' => 13, 'bold' => true ]],
        ];
    }

    public function properties(): array
    {
        return [
            'creator'        => 'Ministry Portal',
            'lastModifiedBy' => 'Ministry Portal',
            'title'          => 'Student Statistics',
            'description'    => 'Ministry Students Statistics Report',
            'subject'        => 'Statistics',
            'keywords'       => 'reports,statistics,students',
            'category'       => 'Statistics',
            'manager'        => 'Mr. Gideon',
            'company'        => 'Quickens',
        ];
    }


}
