<?php

namespace App\Http\Controllers;

use App\Exports\CitizenExport;
use App\Http\Requests\CitizenRequest;
use App\Imports\CitizenImport;
use App\Models\{MasterReligion, Citizen, MasterEducation, MasterFamilyStatus, MasterJob, MasterResidenceStatus, MasterSalary, MasterSocialStatus};
use Illuminate\Http\Request;
use Illuminate\Support\{Carbon};
use Illuminate\Support\Facades\{DB};
use Maatwebsite\Excel\Facades\Excel;

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
        $salaries = MasterSalary::select('id', 'range')->orderBy('range', 'asc')->get();
        $educations = MasterEducation::select('id', 'name')->orderBy('name', 'asc')->get();
        $familyStatuses = MasterFamilyStatus::select('id', 'name')->orderBy('name', 'asc')->get();
        $residenceStatuses = MasterResidenceStatus::select('id', 'name')->orderBy('name', 'asc')->get();
        $socialStatuses = MasterSocialStatus::select('id', 'name')->orderBy('name', 'asc')->get();

        return view('citizen.add', compact('religions', 'jobs', 'salaries', 'educations', 'familyStatuses', 'residenceStatuses', 'socialStatuses'));
    }

    public function store(CitizenRequest $request)
    {
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
            'mSalaryId:id,range',
            'mReligionId:id,name',
            'mFamilyStatusId:id,name',
            'mEducationId:id,name',
            'mResidenceStatusId:id,name',
            'mSocialStatusId:id,name',
        ])->where('id', $id)->first();

        $religions = MasterReligion::select('id', 'name')->orderBy('name', 'asc')->get();
        $jobs = MasterJob::select('id', 'name')->orderBy('name', 'asc')->get();
        $salaries = MasterSalary::select('id', 'range')->orderBy('range', 'asc')->get();
        $educations = MasterEducation::select('id', 'name')->orderBy('name', 'asc')->get();
        $familyStatuses = MasterFamilyStatus::select('id', 'name')->orderBy('name', 'asc')->get();
        $residenceStatuses = MasterResidenceStatus::select('id', 'name')->orderBy('name', 'asc')->get();
        $socialStatuses = MasterSocialStatus::select('id', 'name')->orderBy('name', 'asc')->get();

        $now = Carbon::now();
        $birthDay = Carbon::parse($citizen->birthday);
        $age = $birthDay->diffInYears($now);

        return view('citizen.edit', compact('citizen', 'religions', 'jobs', 'salaries', 'educations', 'familyStatuses', 'residenceStatuses', 'socialStatuses', 'age'));
    }

    public function view($id)
    {
        $citizen = Citizen::with([
            'createdBy:id,name',
            'updatedBy:id,name',
            'mJobId:id,name',
            'mSalaryId:id,range',
            'mReligionId:id,name',
            'mFamilyStatusId:id,name',
            'mEducationId:id,name',
            'mResidenceStatusId:id,name',
            'mSocialStatusId:id,name',
        ])->where('id', $id)->orderBy('name', 'asc')->first();

        $now = Carbon::now();
        $birthDay = Carbon::parse($citizen->birthday);
        $age = $birthDay->diffInYears($now);

        return view('citizen.view', compact('citizen', 'age'));
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

            Excel::import(new CitizenImport, request()->file('file'));
            DB::commit();
            return redirect()->route('citizenTable')->with('success', 'Berhasil di Import');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', $e->getMessage());
        }
    }

    public function export()
    {
        $citizen = Citizen::with([
            'createdBy' => function ($q) {
                $q->select('id', 'name');
            },
            'updatedBy' => function ($q) {
                $q->select('id', 'name');
            },
            'mJobId' => function ($q) {
                $q->select('id', 'name');
            },
            'mSalaryId' => function ($q) {
                $q->select('id', 'range');
            },
            'mReligionId' => function ($q) {
                $q->select('id', 'name');
            },
            'mFamilyStatusId' => function ($q) {
                $q->select('id', 'name');
            },
            'mEducationId' => function ($q) {
                $q->select('id', 'name');
            },
            'mResidenceStatusId' => function ($q) {
                $q->select('id', 'name');
            },
            'mSocialStatusId' => function ($q) {
                $q->select('id', 'name');
            },
        ])
        ->where('m_religion_id', $this->getIslam())
        // ->select(
        //     'name', 'birthday', 'kk_number', 'nik_number', 'gender', 'street', 'rt', 'rw', 'house_number', 'phone', 'marriage_status', 'm_education_id', 'm_job_id', 'm_salary_id', 'm_religion_id', 'm_family_status_id', 'm_residence_status_id', 'm_social_status_id', 'death_date',
        // )
        ->get();
        // return response()->json(['citizen' => $citizen]);
        return Excel::download(new CitizenExport($citizen), 'Data Jamaah.xlsx');
    }

    public function getIslam()
    {
        $islam = MasterReligion::where('name', 'Islam')->first();
        return $islam->id;
    }
}
