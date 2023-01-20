<?php

namespace App\Http\Controllers;

use App\Models\MasterJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB};

class JobController extends Controller
{
    public function table()
    {
        $jobs = MasterJob::with(['updatedBy:id,name', 'createdBy:id,name'])->get();
        return view('master.job', compact('jobs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        DB::beginTransaction();

        try {

            MasterJob::firstOrCreate([
                'name' => $request->name,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);

            DB::commit();
            return redirect()->route('jobTable')->with('success', 'Data Berhasil di Tambah');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', $e->getMessage());
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {

            $get = MasterJob::findOrFail($id);
            $get->delete();

            DB::commit();
            return redirect()->route('jobTable')->with('success', 'Data Berhasil di Hapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', $e->getMessage());
        }
    }
}
