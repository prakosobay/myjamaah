<?php

namespace App\Exports;

use App\Models\Citizen;
use Illuminate\Support\{Carbon};
use Maatwebsite\Excel\Concerns\{FromCollection, WithHeadings, WithMapping, WithStyles};
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CitizenExport implements FromCollection, WithStyles, WithHeadings, WithMapping
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
        // return $this->citizen->map(function ($c, $index) {
        //     return [
        //         'No.' => $index + 1,
        //         'Nama Lengkap' => $c->name,
        //         'Tanggal Lahir' => $c->birthday,
        //         'No. KK' => $c->kk_number,
        //         'NIK' => $c->nik_number,
        //         'Jenis Kelamin' => $c->gender,
        //         'Umur' => function () use ($c){
        //             $now = Carbon::now();
        //             $ultah = Carbon::parse($c->birthday);
        //             $age = $ultah->diffInYears($now);

        //             return $age;
        //         },
        //         'Jalan' => $c->street,
        //         'RT' => $c->rt,
        //         'RW' => $c->rw,
        //         'No. Rumah' => $c->house_number,
        //         'No. Telepon' => $c->phone,
        //         'Status Pernikahan' => $c->marriage_status,
        //         'Pendidikan' => $c->mEducationId->name,
        //         'Pekerjaan' => $c->mJobId->name,
        //         'Penghasilan' => $c->mSalaryId->range,
        //         'Agama' => $c->mReligionId->name,
        //         'Status Keluarga' => $c->mFamilyStatusId->name,
        //         'Status Tempat Tinggal' => $c->mResidenceStatusId->name,
        //         'Status Sosial' => $c->mSocialStatusId->name,
        //         'Tanggal Meninggal' => $c->death_date,
        //     ];
        // });
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
            // 'Umur',
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
            $citizen->birthday,
            $citizen->kk_number,
            $citizen->nik_number,
            $citizen->gender,
            // function () use ($citizen){
            //     $now = Carbon::now();
            //     $ultah = Carbon::parse($citizen->birthday);
            //     $age = $ultah->diffInYears($now);

            //     return $age;
            // },
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
