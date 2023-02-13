<?php

namespace App\Imports;

use App\Models\{Citizen, MasterEducation, MasterFamilyStatus, MasterSalary, MasterJob, MasterReligion, MasterResidenceStatus, MasterSocialStatus};
use Illuminate\Support\{Collection, Str, Carbon};
use Illuminate\Support\Facades\{DB};
use Maatwebsite\Excel\Concerns\{ToCollection, WithHeadingRow};
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
        // die;
        foreach($rows as $row) {

            $job = MasterJob::where('name', $row['pekerjaan'])->select('id')->first();
            if(!$job && !isset($job) && empty($job)){
                throw new Exception('Pekerjaan Belum Terdaftar!');
                // return back()->with('failed', 'Pekerjaan Belum Terdaftar!');
                // dd("a");
                // die;
            }

            $salary = MasterSalary::where('mulai', $row['penghasilan_mulai'])->select('id')->first();
            if(!$salary && !isset($salary) && empty($salary)){
                throw new Exception('Penghasilan Belum Terdaftar!');
                // dd("b");
                // die;
            }

            $religion = MasterReligion::where('name', $row['agama'])->select('id')->first();
            if(!$religion && !isset($religion) && empty($religion)){
                throw new Exception('Agama Belum Terdaftar!');
                // dd("c");
                // die;
            }

            $familyStatus = MasterFamilyStatus::where('name', $row['status_dalam_keluarga'])->select('id')->first();
            if(!$familyStatus && !isset($familyStatus) && empty($familyStatus)){
                throw new Exception('Status dalam Keluarga Belum Terdaftar!');
                // dd("d");
                // die;
            }

            $education = MasterEducation::where('name', $row['pendidikan'])->select('id')->first();
            if(!$education && !isset($education) && empty($education)){
                throw new Exception('Pendidikan Belum Terdaftar!');
                // dd("e");
                // die;
            }

            $residenceStatus = MasterResidenceStatus::where('name', $row['status_tempat_tinggal'])->select('id')->first();
            if(!$residenceStatus && !isset($residenceStatus) && empty($residenceStatus)){
                throw new Exception('Status Tempat Tinggal Belum Terdaftar!');
                // dd("f");
                // die;
            }

            $socialStatus = MasterSocialStatus::where('name', $row['status_sosial'])->select('id')->first();
            if(!$socialStatus && !isset($socialStatus) && empty($socialStatus)){
                throw new Exception('Status Sosial Belum Terdaftar!');
                // dd("g");
                // die;
            }

            $convert = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_lahir']));
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
}
