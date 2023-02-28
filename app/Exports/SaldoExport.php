<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\{FromCollection, WithHeadings, WithStyles};
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SaldoExport implements FromCollection, WithHeadings, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public $query;
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
            'Tanggal Transaksi',
            'Tipe Transaksi',
            'Nama Transaksi',
            'Nominal',
            'Pencatat'
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
