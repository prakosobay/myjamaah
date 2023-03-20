<?php

namespace App\Imports;

use App\Models\{Citizen, MasterEducation, MasterFamilyStatus, MasterSalary, MasterJob, MasterReligion, MasterResidenceStatus, MasterSocialStatus};
use Illuminate\Support\{Collection, Str, Carbon};
use Maatwebsite\Excel\Concerns\{ToCollection, WithHeadingRow, WithStartRow, Importable, SkipsEmptyRows};
use PhpOffice\PhpSpreadsheet\Exception;

class CitizenImport implements ToCollection, WithHeadingRow, WithStartRow, SkipsEmptyRows
{
    use Importable;
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

            if($row[6]) {

                $convert = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[6]));
            }

            if($row[13]) {

                $job = MasterJob::where('name', $row[13])->select('id')->first();
                if(!$job && !isset($job) && $job == null){
                    throw new Exception($row[13] . ' Belum Terdaftar!');
                }
            }

            if($row[14]) {

                $salary = MasterSalary::where('range', $row[14])->select('id')->first();
                if(!$salary && !isset($salary) && $salary == null){
                    throw new Exception($row[14] . ' Belum Terdaftar!');
                }
            }

            if($row[15]) {

                $religion = MasterReligion::where('name', $row[15])->select('id')->first();
                if(!$religion && !isset($religion) && $religion == null){
                    throw new Exception($row[15] . ' Belum Terdaftar!');
                }
            }

            if($row[18]) {

                $familyStatus = MasterFamilyStatus::where('name', $row[18])->select('id')->first();
                if(!$familyStatus && !isset($familyStatus) && $familyStatus == null){
                    throw new Exception($row[18] . ' Belum Terdaftar!');
                }
            }

            if($row[19]) {

                $education = MasterEducation::where('name', $row[19])->select('id')->first();
                if(!$education && !isset($education) && $education == null){
                    throw new Exception($row[19] . ' Belum Terdaftar!');
                }
            }

            if($row[20]) {

                $residenceStatus = MasterResidenceStatus::where('name', $row[20])->select('id')->first();
                if(!$residenceStatus && !isset($residenceStatus) && $residenceStatus == null){
                    throw new Exception($row[20] . ' Belum Terdaftar!');
                }
            }

            if($row[21]) {

                $socialStatus = MasterSocialStatus::where('name', $row[21])->select('id')->first();
                if(!$residenceStatus && !isset($residenceStatus) && $socialStatus == null){
                    throw new Exception($row[21] . ' Belum Terdaftar!');
                }
            }

            $citizen = Citizen::where('nik_number', $row[4])->first();
            if(isset($citizen) && !empty($citizen)){

                $citizen->update([
                    'kk_number' => $row[3],
                    'name' => $row[5],
                    'birthday' => (isset($convert) ? $convert : null),
                    'gender' => $row[7],
                    'street' => $row[8],
                    'rt' => $row[9],
                    'rw' => $row[10],
                    'house_number' => $row[11],
                    'phone' => $row[12],
                    'm_job_id' => (isset($job) ? $job->id : null),
                    'm_salary_id' => (isset($salary) ? $salary->id : null),
                    'm_religion_id' => (isset($religion) ? $religion->id : null),
                    'marriage_status' => $row[17],
                    'm_family_status_id' => (isset($familyStatus) ? $familyStatus->id : null),
                    'm_education_id' => (isset($education) ? $education->id : null),
                    'm_residence_status_id' => (isset($residenceStatus) ? $residenceStatus->id : null),
                    'm_social_status_id' => (isset($socialStatus) ? $socialStatus->id : null),
                    'updated_by' => auth()->user()->id,
                ]);

            } else {

                $id = Str::uuid();
                Citizen::insert([
                    'id' => $id,
                    'nik_number' => $row[4],
                    'kk_number' => $row[3],
                    'name' => $row[5],
                    'birthday' => (isset($convert) ? $convert : null),
                    'gender' => $row[7],
                    'street' => $row[8],
                    'rt' => $row[9],
                    'rw' => $row[10],
                    'house_number' => $row[11],
                    'phone' => $row[12],
                    'm_job_id' => (isset($job) ? $job->id : null),
                    'm_salary_id' => (isset($salary) ? $salary->id : null),
                    'm_religion_id' => (isset($religion) ? $religion->id : null),
                    'marriage_status' => $row[17],
                    'm_family_status_id' => (isset($familyStatus) ? $familyStatus->id : null),
                    'm_education_id' => (isset($education) ? $education->id : null),
                    'm_residence_status_id' => (isset($residenceStatus) ? $residenceStatus->id : null),
                    'm_social_status_id' => (isset($socialStatus) ? $socialStatus->id : null),
                    'updated_by' => auth()->user()->id,
                    'created_by' => auth()->user()->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function startRow(): int
    {
        return 11;
    }
}
