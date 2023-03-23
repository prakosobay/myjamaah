<?php

namespace App\Exports;

use Illuminate\Support\{Carbon};
use Maatwebsite\Excel\Concerns\{FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize};
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanPetugasExport implements FromCollection, WithHeadings, WithStyles, WithMapping, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public $query;
    private $count = 1;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function collection()
    {
        return $this->query;
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Petugas',
            'Tugas',
            'Tanggal',
            'Status',
            'Nominal',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }

    public function map($query): array
    {
        return [
            $this->count++,
            $query->mPetugasId->name,
            $query->duty,
            isset($query->date) ? Carbon::createFromFormat('Y-m-d', $query->date)->format('d/m/Y') : null,
            $query->status,
            $query->nominal,
        ];
    }
}
