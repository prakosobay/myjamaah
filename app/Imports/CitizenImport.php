<?php

namespace App\Imports;

use App\Models\{Citizen, MasterEducation, MasterFamilyStatus, MasterSalary, MasterJob, MasterReligion, MasterResidenceStatus, MasterSocialStatus};
use Illuminate\Support\{Collection, Str, Carbon};
use Maatwebsite\Excel\Concerns\{ToCollection, WithHeadingRow, WithStartRow};
use PhpOffice\PhpSpreadsheet\Exception;

class CitizenImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        // echo '<pre>';
        // var_dump($rows);
        // dd($rows);
        // return response()->json(['rows' => $rows]);
        // die;
        foreach($rows as $row) {

            $job = MasterJob::where('name', $row['jalan'])->select('id')->first();
            if(!$job && !isset($job) && empty($job)){
                throw new Exception('Pekerjaan Belum Terdaftar!');
                // return back()->with('failed', 'Pekerjaan Belum Terdaftar!');
                // dd("a");
                // die;
            }

            $salary = MasterSalary::where('range', $row['Penghasilan per Bulan'])->select('id')->first();
            if(!$salary && !isset($salary) && empty($salary)){
                throw new Exception('Penghasilan Belum Terdaftar!');
                // dd("b");
                // die;
            }

            $religion = MasterReligion::where('name', $row['Agama'])->select('id')->first();
            if(!$religion && !isset($religion) && empty($religion)){
                throw new Exception('Agama Belum Terdaftar!');
                // dd("c");
                // die;
            }

            $familyStatus = MasterFamilyStatus::where('name', $row['Status Dalam Keluarga'])->select('id')->first();
            if(!$familyStatus && !isset($familyStatus) && empty($familyStatus)){
                throw new Exception('Status dalam Keluarga Belum Terdaftar!');
                // dd("d");
                // die;
            }

            $education = MasterEducation::where('name', $row['Pendidikan'])->select('id')->first();
            if(!$education && !isset($education) && empty($education)){
                throw new Exception('Pendidikan Belum Terdaftar!');
                // dd("e");
                // die;
            }

            $residenceStatus = MasterResidenceStatus::where('name', $row['Status Tempat Tinggal'])->select('id')->first();
            if(!$residenceStatus && !isset($residenceStatus) && empty($residenceStatus)){
                throw new Exception('Status Tempat Tinggal Belum Terdaftar!');
                // dd("f");
                // die;
            }

            $socialStatus = MasterSocialStatus::where('name', $row['Status Sosial'])->select('id')->first();
            if(!$socialStatus && !isset($socialStatus) && empty($socialStatus)){
                throw new Exception('Status Sosial Belum Terdaftar!');
                // dd("g");
                // die;
            }

            $convert = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['Tanggal Lahir']));
            // dd($job->id);

            $citizen = Citizen::where('nik_number', $row['nik'])->first();
            // dd($citizen);
            if(isset($citizen) && !empty($citizen)){

                $citizen->update([
                    'kk_number' => $row['kk'],
                    'name' => $row['nama'],
                    'birthday' => $convert,
                    'gender' => $row['jenis_kelamin'],
                    'street' => $row['jalan'],
                    'rt' => $row['rt'],
                    'rw' => $row['rw'],
                    'house_number' => $row['no_rumah'],
                    'phone' => $row['no_hp'],
                    'm_job_id' => $job->id,
                    'm_salary_id' => $salary->id,
                    'm_religion_id' => $religion->id,
                    'marriage_status' => $row['status_perkawinan'],
                    'm_family_status_id' => $familyStatus->id,
                    'm_education_id' => $education->id,
                    'm_residence_status_id' => $residenceStatus->id,
                    'm_social_status_id' => $socialStatus->id,
                    'updated_by' => auth()->user()->id,
                ]);
            } else {

                $id = Str::uuid();
                $citizen = Citizen::create([
                    'id' => $id,
                    'nik_number' => $row['nik'],
                    'kk_number' => $row['kk'],
                    'name' => $row['nama'],
                    'birthday' => $convert,
                    'gender' => $row['jenis_kelamin'],
                    'street' => $row['jalan'],
                    'rt' => $row['rt'],
                    'rw' => $row['rw'],
                    'house_number' => $row['no_rumah'],
                    'phone' => $row['no_hp'],
                    'm_job_id' => $job->id,
                    'm_salary_id' => $salary->id,
                    'm_religion_id' => $religion->id,
                    'marriage_status' => $row['status_perkawinan'],
                    'm_family_status_id' => $familyStatus->id,
                    'm_education_id' => $education->id,
                    'm_residence_status_id' => $residenceStatus->id,
                    'm_social_status_id' => $socialStatus->id,
                    'updated_by' => auth()->user()->id,
                    'created_by' => auth()->user()->id,
                ]);
            }
        }
    }

    // public function startRow(): int
    // {
    //     return 10;
    // }
}
