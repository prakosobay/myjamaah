<?php

namespace App\Http\Controllers;

use App\Models\{MasterReligion};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB};

class ReligionController extends Controller
{
    public function table()
    {
        $religions = MasterReligion::with(['updatedBy:id,name', 'createdBy:id,name'])->get();
        return view('master.religion', compact('religions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        DB::beginTransaction();

        try {

            MasterReligion::firstOrCreate([
                'name' => $request->name,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);

            DB::commit();
            return redirect()->route('religionTable')->with('success', 'Data Berhasil di Tambah');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', $e->getMessage());
        }
    }

    public function delete($id)
    {
        db::beginTransaction();

        try {

            $get = MasterReligion::findOrFail($id);
            $get->delete();

            DB::commit();
            return redirect()->route('religionTable')->with('success', 'Data Berhasil di Hapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', $e->getMessage());
        }
    }
}
