<?php

namespace App\Http\Controllers;

use App\Models\{MasterRt, MasterRw};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB};

class RtRwController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'rt' => ['required', 'numeric'],
            'rw' => ['required', 'numeric'],
        ]);

        DB::beginTransaction();

        try {

            $rw = MasterRw::create([
                'number' => $request->rw,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);

            MasterRt::create([
                'number' => $request->rt,
                'm_rw_id' => $rw->id,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);

            DB::commit();
            return redirect()->route('rtrwTable')->with('success', 'Data Berhasil di Tambah');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', $e->getMessage());
        }
    }

    public function table()
    {
        $getRt = MasterRt::with(['updatedBy:id,name', 'createdBy:id,name', 'mRwId:id,name'])->get();
        return view('master.rtrw', compact('getRt'));
    }
}
