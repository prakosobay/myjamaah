<?php

namespace App\Http\Controllers;

use App\Models\{MasterResidenceStatus};
use Illuminate\Support\Facades\{DB};
use Illuminate\Http\Request;

class ResidenceStatusController extends Controller
{
    public function table()
    {
        $residenceStatuses = MasterResidenceStatus::with(['createdBy:id,name', 'updatedBy:id,name'])->orderBy('name', 'asc')->get();
        return view('master.residenceStatus', compact('residenceStatuses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        DB::beginTransaction();

        try {

            MasterResidenceStatus::firstOrCreate([
                'name' => $request->name,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);

            DB::commit();
            return redirect()->route('residenceStatusTable')->with('success', 'Data Berhasil di Tambah');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', $e->getMessage());
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {

            $getData = MasterResidenceStatus::findOrFail($id);
            $getData->delete();

            DB::commit();
            return redirect()->route('residenceStatusTable')->with('success', 'Data Berhasil di Hapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', $e->getMessage());
        }
    }
}
