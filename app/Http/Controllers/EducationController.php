<?php

namespace App\Http\Controllers;

use App\Models\MasterEducation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB};

class EducationController extends Controller
{
    public function table()
    {
        $educations = MasterEducation::with(['createdBy:id,name', 'updatedBy:id,name'])->orderBy('updated_at', 'asc')->get();
        return view('master.education', compact('educations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        DB::beginTransaction();

        try {

            MasterEducation::firstOrCreate([
                'name' => $request->name,
                'updated_by' => auth()->user()->id,
                'created_by' => auth()->user()->id,
            ]);

            DB::commit();
            return redirect()->route('educationTable')->with('success', 'Data Berhasil di Tambah');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', $e->getMessage());
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {

            $get = MasterEducation::findOrFail($id);
            $get->delete();

            DB::commit();
            return redirect()->route('educationTable')->with('success', 'Data Berhasil di Hapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', $e->getMessage());
        }
    }
}
