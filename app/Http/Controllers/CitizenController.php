<?php

namespace App\Http\Controllers;

use App\Models\{MasterReligion, Citizen, MasterEducation, MasterFamilyStatus, MasterJob, MasterResidenceStatus, MasterSalary, MasterSocialStatus};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB};

class CitizenController extends Controller
{
    public function table()
    {
        $citizens = Citizen::with([
            'updatedBy:id,name',
            'createdBy:id.name',
            ])->get();
        return view('citizen.citizen', compact('citizens'));
    }

    public function add()
    {
        $religions = MasterReligion::select('id', 'name')->orderBy('name', 'asc')->get();
        $jobs = MasterJob::select('id', 'name')->orderBy('name', 'asc')->get();
        $salaries = MasterSalary::select('id', 'mulai', 'sampai')->orderBy('mulai', 'asc')->get();
        $educations = MasterEducation::select('id', 'name')->orderBy('name', 'asc')->get();
        $familyStatuses = MasterFamilyStatus::select('id', 'name')->orderBy('name', 'asc')->get();
        $residenceStatuses = MasterResidenceStatus::select('id', 'name')->orderBy('name', 'asc')->get();
        $socialStatuses = MasterSocialStatus::select('id', 'name')->orderBy('name', 'asc')->get();
        return view('citizen.add', compact('religions', 'jobs', 'salaries', 'educations', 'familyStatuses', 'residenceStatuses', 'socialStatuses'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

            Citizen::create([
                'name' => $request->name,
                'birthday' => $request->birthday,
                'nik' => $request->nik,
                'gender' => $request->gender,
                'kk' => $request->kk,
                'phone' => $request->phone,
                'street' => $request->street,
                'rt' => $request->rt,
                'rw' => $request->rw,
                'house_number' => $request->house_number,
                'm_job_id' => $request->job,
                'm_education_id' => $request->education,
                'm_residence_status_id' => $request->residenceStatus,
                'm_salary_id' => $request->salary,
                'marriageStatus' => $request->marriageStatus,
                'm_social_status_id' => $request->socialStatus,
                'm_religion_id' => $request->religion,
                'm_family_status_id' => $request->familyStatus,
                'isDeath' => $request->isDeath,
                'death_date' => $request->death_date,
            ]);

            DB::commit();
            return redirect()->route('citizenTable')->with('success', 'Data Berhasil di Tambah');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', $e->getMessage());
        }
    }
}
