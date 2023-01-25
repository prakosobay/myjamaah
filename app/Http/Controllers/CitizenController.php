<?php

namespace App\Http\Controllers;

use App\Http\Requests\CitizenRequest;
use App\Models\{MasterReligion, Citizen, MasterEducation, MasterFamilyStatus, MasterJob, MasterResidenceStatus, MasterSalary, MasterSocialStatus};
use Illuminate\Http\Request;
use Illuminate\Support\{Carbon};
use Illuminate\Support\Facades\{DB};

class CitizenController extends Controller
{
    public function table()
    {
        $citizens = Citizen::with(['mReligionId:id,name'])->orderBy('name', 'asc')->get();
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

    public function store(CitizenRequest $request)
    {
        $now = Carbon::now();
        $birthDay = Carbon::parse($request->birthday);
        $age = $birthDay->diffInYears($now);

        DB::beginTransaction();

        try {

            Citizen::create([
                'name' => $request->name,
                'birthday' => $request->birthday,
                'nik_number' => $request->nik,
                'gender' => $request->gender,
                'kk_number' => $request->kk,
                'phone' => $request->phone,
                'street' => $request->street,
                'rt' => $request->rt,
                'rw' => $request->rw,
                'house_number' => $request->house_number,
                'm_job_id' => $request->job,
                'm_education_id' => $request->education,
                'm_residence_status_id' => $request->residenceStatus,
                'm_salary_id' => $request->salary,
                'marriage_status' => $request->marriageStatus,
                'm_social_status_id' => $request->socialStatus,
                'm_religion_id' => $request->religion,
                'm_family_status_id' => $request->familyStatus,
                'is_death' => $request->is_death,
                'death_date' => $request->death_date,
                'age' => $age,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);

            DB::commit();
            return redirect()->route('citizenTable')->with('success', 'Data Berhasil di Tambah');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', $e->getMessage());
        }
    }

    public function update(CitizenRequest $request, $id)
    {
        $now = Carbon::now();
        $birthDay = Carbon::parse($request->birthday);
        $age = $birthDay->diffInYears($now);

        DB::beginTransaction();

        try {

            $get = Citizen::findOrFail($id);
            $get->update([
                'name' => $request->name,
                'birthday' => $request->birthday,
                'nik_number' => $request->nik,
                'gender' => $request->gender,
                'kk_number' => $request->kk,
                'phone' => $request->phone,
                'street' => $request->street,
                'rt' => $request->rt,
                'rw' => $request->rw,
                'house_number' => $request->house_number,
                'm_job_id' => $request->job,
                'm_education_id' => $request->education,
                'm_residence_status_id' => $request->residenceStatus,
                'm_salary_id' => $request->salary,
                'marriage_status' => $request->marriageStatus,
                'm_social_status_id' => $request->socialStatus,
                'm_religion_id' => $request->religion,
                'm_family_status_id' => $request->familyStatus,
                'is_death' => $request->is_death,
                'death_date' => $request->death_date,
                'age' => $age,
                'updated_by' => auth()->user()->id,
            ]);

            DB::commit();
            return redirect()->route('citizenTable')->with('success', 'Data Berhasil di Perbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', $e->getMessage());
        }
    }

    public function edit($id)
    {
        $citizen = Citizen::with([
            'createdBy:id,name',
            'updatedBy:id,name',
            'mJobId:id,name',
            'mSalaryId:id,mulai,sampai',
            'mReligionId:id,name',
            'mFamilyStatusId:id,name',
            'mEducationId:id,name',
            'mResidenceStatusId:id,name',
            'mSocialStatusId:id,name',
        ])->where('id', $id)->first();
        $religions = MasterReligion::select('id', 'name')->orderBy('name', 'asc')->get();
        $jobs = MasterJob::select('id', 'name')->orderBy('name', 'asc')->get();
        $salaries = MasterSalary::select('id', 'mulai', 'sampai')->orderBy('mulai', 'asc')->get();
        $educations = MasterEducation::select('id', 'name')->orderBy('name', 'asc')->get();
        $familyStatuses = MasterFamilyStatus::select('id', 'name')->orderBy('name', 'asc')->get();
        $residenceStatuses = MasterResidenceStatus::select('id', 'name')->orderBy('name', 'asc')->get();
        $socialStatuses = MasterSocialStatus::select('id', 'name')->orderBy('name', 'asc')->get();
        return view('citizen.edit', compact('citizen', 'religions', 'jobs', 'salaries', 'educations', 'familyStatuses', 'residenceStatuses', 'socialStatuses'));
    }

    public function view($id)
    {
        $citizen = Citizen::with([
            'createdBy:id,name',
            'updatedBy:id,name',
            'mJobId:id,name',
            'mSalaryId:id,mulai,sampai',
            'mReligionId:id,name',
            'mFamilyStatusId:id,name',
            'mEducationId:id,name',
            'mResidenceStatusId:id,name',
            'mSocialStatusId:id,name',
        ])->where('id', $id)->first();
        return view('citizen.view', compact('citizen'));
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {

            $get = Citizen::findOrFail($id);
            $get->delete();

            DB::commit();
            return redirect()->route('citizenTable')->with('success', 'Data Berhasil di Hapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', $e->getMessage());
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file'],
        ]);

        DB::beginTransaction();

        try {

            DB::commit();
            return redirect()->route('citizenTable')->with('success', 'Berhasil di Import');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', $e->getMessage());
        }
    }
}
