<?php

namespace App\Exports;

use App\Models\Citizen;
use Illuminate\Support\{Carbon};
use Maatwebsite\Excel\Concerns\{FromCollection, FromQuery, WithHeadings, WithMapping, WithStyles};
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CitizenExport implements FromCollection, WithHeadings, WithStyles, WithMapping
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
            'Tanggal Meninggal',
        ];
    }

    public function map($citizen): array
    {
        return [
            $this->count++,
            $citizen->name,
            // DateTime::createFromFormat('Y/m/d', $citizen->birthday),
            $citizen->birthday,
            $citizen->kk_number,
            $citizen->nik_number,
            $citizen->gender,
            $this->getNow(),
            $citizen->street,
            $citizen->rt,
            $citizen->rw,
            $citizen->house_number,
            $citizen->phone,
            $citizen->marriage_status,
            $citizen->mEducationId->name,
            $citizen->mJobId->name,
            $citizen->mSalaryId->range,
            $citizen->mReligionId->name,
            $citizen->mFamilyStatusId->name,
            $citizen->mResidenceStatusId->name,
            $citizen->mSocialStatusId->name,
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
