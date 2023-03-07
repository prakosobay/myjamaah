<?php

namespace App\Imports;

use App\Models\{Citizen, MasterEducation, MasterFamilyStatus, MasterSalary, MasterJob, MasterReligion, MasterResidenceStatus, MasterSocialStatus};
use Illuminate\Support\{Collection, Str, Carbon};
use Maatwebsite\Excel\Concerns\{ToCollection, WithHeadingRow, WithStartRow};
use PhpOffice\PhpSpreadsheet\Exception;

class CitizenImport implements ToCollection, WithHeadingRow, WithStartRow
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

            $convert = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[6]));

            $job = MasterJob::where('name', $row[13])->select('id')->first();
            if(!$job && !isset($job) && empty($job) && $job === ''){
                throw new Exception('Pekerjaan Belum Terdaftar!');
                // return back()->with('failed', 'Pekerjaan Belum Terdaftar!');
                // dd("a");
                // die;
            }

            $salary = MasterSalary::where('range', $row[14])->select('id')->first();
            // dd($salary->id);
            if(!$salary && !isset($salary) && empty($salary) && $salary === ''){
                throw new Exception('Penghasilan Belum Terdaftar!');
                // dd("b");
                // die;
            }

            $religion = MasterReligion::where('name', $row[15])->select('id')->first();
            if(!$religion && !isset($religion) && empty($religion) && $religion === ''){
                throw new Exception('Agama Belum Terdaftar!');
                // dd("c");
                // die;
            }

            $familyStatus = MasterFamilyStatus::where('name', $row[18])->select('id')->first();
            if(!$familyStatus && !isset($familyStatus) && empty($familyStatus) && $familyStatus === ''){
                throw new Exception('Status dalam Keluarga Belum Terdaftar!');
                // dd("d");
                // die;
            }

            $education = MasterEducation::where('name', $row[19])->select('id')->first();
            if(!$education && !isset($education) && empty($education) && $education === ''){
                throw new Exception('Pendidikan Belum Terdaftar!');
                // dd("e");
                // die;
            }

            $residenceStatus = MasterResidenceStatus::where('name', $row[20])->select('id')->first();
            if(!$residenceStatus && !isset($residenceStatus) && empty($residenceStatus) && $residenceStatus === ''){
                throw new Exception('Status Tempat Tinggal Belum Terdaftar!');
                // dd("f");
                // die;
            }

            $socialStatus = MasterSocialStatus::where('name', $row[21])->select('id')->first();
            if(!$socialStatus && !isset($socialStatus) && empty($socialStatus) && $socialStatus === ''){
                throw new Exception('Status Sosial Belum Terdaftar!');
                // dd("g");
                // die;
            }

            $citizen = Citizen::where('nik_number', $row[4])->first();
            if(isset($citizen) && !empty($citizen)){

                $citizen->update([
                    'kk_number' => $row[3],
                    'name' => $row[5],
                    'birthday' => $convert,
                    'gender' => $row[7],
                    'street' => $row[8],
                    'rt' => $row[9],
                    'rw' => $row[10],
                    'house_number' => $row[11],
                    'phone' => $row[12],
                    'm_job_id' => $job->id,
                    'm_salary_id' => $salary->id,
                    'm_religion_id' => $religion->id,
                    'marriage_status' => $row[17],
                    'm_family_status_id' => $familyStatus->id,
                    'm_education_id' => $education->id,
                    'm_residence_status_id' => $residenceStatus->id,
                    'm_social_status_id' => $socialStatus->id,
                    'updated_by' => auth()->user()->id,
                ]);
            } else {

                $id = Str::uuid();
                $tes = Citizen::create([
                    'id' => $id,
                    'nik_number' => $row[4],
                    'kk_number' => $row[3],
                    'name' => $row[5],
                    'birthday' => $convert,
                    'gender' => $row[7],
                    'street' => $row[8],
                    'rt' => $row[9],
                    'rw' => $row[10],
                    'house_number' => $row[11],
                    'phone' => $row[12],
                    'm_job_id' => $job->id,
                    'm_salary_id' => $salary->id,
                    'm_religion_id' => $religion->id,
                    'marriage_status' => $row[17],
                    'm_family_status_id' => $familyStatus->id,
                    'm_education_id' => $education->id,
                    'm_residence_status_id' => $residenceStatus->id,
                    'm_social_status_id' => $socialStatus->id,
                    'updated_by' => auth()->user()->id,
                    'created_by' => auth()->user()->id,
                    // 'updated_at' => now(),
                    // 'created_at' => now(),
                ]);
                // dd($tes);
            }
        }
    }

    public function startRow(): int
    {
        return 11;
    }
}
