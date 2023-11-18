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


class SubjectExcelExport implements FromArray,
                                    WithHeadings,
                                    ShouldAutoSize,
                                    WithStyles,
                                    WithProperties
{
    protected $data;
    protected $msg;
    protected $header;
    protected $subjects_list;

    public function __construct(array $header, array $subjects_list, ?string $msg = null, array $data)
    {
        $this->data = $data;
        $this->msg = $msg;
        $this->header = $header;
        $this->subjects_list = $subjects_list;
    }

    public function array(): array
    {
        return $this->data;
    }
    public function headings(): array
    {
        return [
            ['Digi-Realm I.T Solution'],
            ['NUMBER OF TEACHERS PER SUBJECT IN PUBLIC SECONDARY SCHOOLS'],
            [$this->msg],
            [],
            $this->header,
            $this->subjects_list, 
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
            'manager'        => 'Mr. Abel Oragbon',
            'company'        => 'Digi-Realm',
        ];
    }


}
