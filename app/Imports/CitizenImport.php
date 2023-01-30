<?php

namespace App\Imports;

use App\Models\{Citizen, MasterEducation, MasterFamilyStatus, MasterSalary, MasterJob, MasterReligion, MasterResidenceStatus, MasterSocialStatus};
use Illuminate\Support\{Collection, Str, Carbon};
use Illuminate\Support\Facades\{DB};
use Maatwebsite\Excel\Concerns\{ToCollection, WithHeadingRow};

class CitizenImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        // echo '<pre>';
        // var_dump($rows);
        // die;
        foreach($rows as $row) {

            $job = MasterJob::where('name', $row['pekerjaan'])->select('id')->first();
            if(!$job && !isset($job) && empty($job)){
                return back()->with('failed', 'Pekerjaan Belum Terdaftar!');
                dd("a");
                die;
            }

            $salary = MasterSalary::where('mulai', $row['penghasilan'])->select('id')->first();
            if(!$salary && !isset($salary) && empty($salary)){
                return back()->with('failed', 'Penghasilan Belum Terdaftar!');
                dd("b");
                die;
            }

            $religion = MasterReligion::where('name', $row['agama'])->select('id')->first();
            if(!$religion && !isset($religion) && empty($religion)){
                return back()->with('failed', 'Agama Belum Terdaftar!');
                dd("c");
                die;
            }

            $familyStatus = MasterFamilyStatus::where('name', $row['status_dalam_keluarga'])->select('id')->first();
            if(!$familyStatus && !isset($familyStatus) && empty($familyStatus)){
                return back()->with('failed', 'Status Dalam Keluarga Belum Terdaftar!');
                dd("d");
                die;
            }

            $education = MasterEducation::where('name', $row['pendidikan'])->select('id')->first();
            if(!$education && !isset($education) && empty($education)){
                return back()->with('failed', 'Pendidikan Belum Terdaftar!');
                dd("e");
                die;
            }

            $residenceStatus = MasterResidenceStatus::where('name', $row['status_tempat_tinggal'])->select('id')->first();
            if(!$residenceStatus && !isset($residenceStatus) && empty($residenceStatus)){
                return back()->with('failed', 'Status Tempat Tinggal Belum Terdaftar!');
                dd("f");
                die;
            }

            $socialStatus = MasterSocialStatus::where('name', $row['status_sosial'])->select('id')->first();
            if(!$socialStatus && !isset($socialStatus) && empty($socialStatus)){
                return back()->with('failed', 'Status Sosial Belum Terdaftar!');
                dd("g");
                die;
            }

            $convert = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_lahir']));
            // dd($job->id);

            $citizen = Citizen::where('nik_number', $row['nik'])->first();
            // dd($citizen);
            if($citizen){

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
                    'marriage_status' => $row['status_pernikahan'],
                    'm_family_status_id' => $familyStatus->id,
                    'm_education_id' => $education->id,
                    'm_residence_status_id' => $residenceStatus->id,
                    'm_social_status' => $socialStatus->id,
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
                    'marriage_status' => $row['status_pernikahan'],
                    'm_family_status_id' => $familyStatus->id,
                    'm_education_id' => $education->id,
                    'm_residence_status_id' => $residenceStatus->id,
                    'm_social_status' => $socialStatus->id,
                ]);
            }

            dd($citizen);die;
            // dd($age);
            // $citizen = Citizen::updateOrCreate(
            //     ['nik_number' => $row['nik'], ],
            //     [
            //         'kk_number' => $row['kk'],
            //         'name' => $row['nama'],
            //         'birthday' => $convert,
            //         'gender' => $row['jenis_kelamin'],
            //         'street' => $row['jalan'],
            //         'age' => $age,
            //         'rt' => $row['rt'],
            //         'rw' => $row['rw'],
            //         'house_number' => $row['no_rumah'],
            //         'phone' => $row['no_hp'],
            //         'm_job_id' => $job->id,
            //         'm_salary_id' => $salary->id,
            //         'm_religion_id' => $religion->id,
            //         'marriage_status' => $row['status_pernikahan'],
            //         'm_family_status_id' => $familyStatus->id,
            //         'm_education_id' => $education->id,
            //         'm_residence_status_id' => $residenceStatus->id,
            //         'm_social_status' => $socialStatus->id,
            //     ]
            // );
            // $citizen = Citizen::updateOrInsert(
            //     ['nik_number' => $row['nik'] ],
            //     [
            //         'kk_number' => $row['kk'],
            //         'name' => $row['nama'],
            //         'birthday' => $convert,
            //         'gender' => $row['jenis_kelamin'],
            //         'street' => $row['jalan'],
            //         'age' => $age,
            //         'rt' => $row['rt'],
            //         'rw' => $row['rw'],
            //         'house_number' => $row['no_rumah'],
            //         'phone' => $row['no_hp'],
            //         'm_job_id' => $job->id,
            //         'm_salary_id' => $salary->id,
            //         'm_religion_id' => $religion->id,
            //         'marriage_status' => $row['status_pernikahan'],
            //         'm_family_status_id' => $familyStatus->id,
            //         'm_education_id' => $education->id,
            //         'm_residence_status_id' => $residenceStatus->id,
            //         'm_social_status' => $socialStatus->id,
            //     ]
            // );
        }
    }
}
