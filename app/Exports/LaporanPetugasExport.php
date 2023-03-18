<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\{FromCollection, WithHeadings, WithMapping, WithStyles};
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanPetugasExport implements FromCollection, WithHeadings, WithStyles, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $query;
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
            'No.',
            'Nama Petugas',
            'Tugas',
            'Tanggal',
            'Status',
            'Nominal',
        ];
    }

    public function map($query): array
    {
        return [
            $this->count++,
            $query->mPetugasId->name,
            $query->duty,
            $query->date,
            $query->status,
            $query->nominal,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }
}
