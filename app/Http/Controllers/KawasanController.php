<?php

namespace App\Http\Controllers;

use App\Models\MasterKawasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB};

class KawasanController extends Controller
{
    public function table()
    {
        $kawasans = MasterKawasan::with(['updatedBy:id,name', 'createdBy:id,name'])->get();
        return view('master.kawasan', compact('kawasans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'rt' => ['required', 'numeric', 'digits:3'],
            'rw' => ['required', 'numeric', 'digits:3'],
        ]);

        DB::beginTransaction();

        try {

            MasterKawasan::firstOrCreate([
                'rt' => $request->rt,
                'rw' => $request->rw,
                'updated_by' => auth()->user()->id,
                'created_by' => auth()->user()->id,
            ]);

            DB::commit();
            return redirect()->route('kawasanTable')->with('status', 'Data Berhasil di Tambah');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', $e->getMessage());
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {

            $get = MasterKawasan::findOrFail($id);
            $get->delete();

            DB::commit();
            return redirect()->route('kawasanTable')->with('success', 'Data Berhasil di Hapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', $e->getMessage());
        }
    }
}
