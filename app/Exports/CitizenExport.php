<?php

namespace App\Exports;

use Illuminate\Support\{Carbon};
use Maatwebsite\Excel\Concerns\{FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize};
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CitizenExport implements FromCollection, WithStyles, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $citizen;
    private $count = 1;

    public function __construct($citizen)
    {
        $this->citizen = $citizen;
    }

    public function collection()
    {
        return $this->citizen;
    }

    public function getNow()
    {
        $now = Carbon::now();
        foreach($this->citizen as $p) {
            $birthDay = Carbon::parse($p->birthday);
            $citizen = $birthDay->diffInYears($now);
        }
        return $citizen;
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Lengkap',
            'Tanggal Lahir',
            'No. KK',
            'NIK',
            'Jenis Kelamin',
            'Umur',
            'Jalan',
            'RT',
            'RW',
            'No. Rumah',
            'No. Telepon',
            'Status Pernikahan',
            'Pendidikan',
            'Pekerjaan',
            'Penghasilan',
            'Agama',
            'Status Keluarga',
            'Status Tempat Tinggal',
            'Status Sosial',
            'Keterangan',
            'Tanggal Meninggal',
        ];
    }

    public function map($citizen): array
    {
        return [
            $this->count++,
            $citizen->name,
            isset($citizen->birthday) ? Carbon::createFromFormat('Y-m-d', $citizen->birthday)->format('d/m/Y') : null,
            $citizen->kk_number,
            $citizen->nik_number,
            $citizen->gender,
            isset($citizen->birthday) ? Carbon::parse($citizen->birthday)->diffInYears(Carbon::now()) : null,
            $citizen->street,
            $citizen->rt,
            $citizen->rw,
            $citizen->house_number,
            $citizen->phone,
            $citizen->marriage_status,
            isset($citizen->mEducationId->name) ? $citizen->mEducationId->name : null,
            isset($citizen->mJobId->name) ? $citizen->mJobId->name : null,
            isset($citizen->mSalaryId->range) ? $citizen->mSalaryId->range : null,
            isset($citizen->mReligionId->name) ? $citizen->mReligionId->name : null,
            isset($citizen->mFamilyStatusId->name) ? $citizen->mFamilyStatusId->name : null,
            isset($citizen->mResidenceStatusId->name) ? $citizen->mResidenceStatusId->name : null,
            isset($citizen->mSocialStatusId->name) ? $citizen->mSocialStatusId->name : null,
            $citizen->ket,
            $citizen->death_date,
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
