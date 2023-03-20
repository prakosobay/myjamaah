<?php

namespace App\Http\Controllers;

use App\Exports\LaporanPetugasExport;
use App\Http\Requests\StoreLaporanPetugas;
use Illuminate\Http\Request;
use App\Models\{LaporanPetugas, MasterPetugas};
use Illuminate\Support\Facades\{DB};
use Yajra\DataTables\Datatables;
use Illuminate\Support\{Str, Carbon};
use Maatwebsite\Excel\Facades\Excel;

class LaporanPetugasController extends Controller
{
    public function table()
    {
        $petugas = MasterPetugas::all();
        return view('petugas.table', compact('petugas'));
    }

    public function edit($id)
    {
        $petugas = LaporanPetugas::findOrFail($id);
        return view('petugas.edit', compact('petugas'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

            $create = LaporanPetugas::create([
                'm_petugas_id' => $request->name,
                'duty' => $request->duty,
                'nominal' => $request->nominal,
                'created_by' => auth()->user()->id,
                'date' => $request->date,
                'status' => $request->status,
            ]);

            DB::commit();
            return redirect()->route('tableLaporanPetugas')->with('success', 'Data Berhasil Tersimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {

            $laporan = LaporanPetugas::findOrFail($id);
            $laporan->update([
                'duty' => $request->duty,
                'nominal' => $request->nominal,
                'date' => $request->date,
                'status' => $request->status,
            ]);

            DB::commit();
            return redirect()->route('tableLaporanPetugas')->with('success', 'Berhasil di Update');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', $e->getMessage());
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {

            $laporan = LaporanPetugas::findOrFail($id);
            $laporan->delete();

            DB::commit();
            return back()->with('success', 'Terhapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', $e->getMessage());
        }
    }

    public function yajra()
    {
        $query = LaporanPetugas::with(['createdBy:id,name', 'mPetugasId:id,name'])->orderBy('date', 'asc')->get();
        return Datatables::of($query)
        ->editColumn('date', function ($query) {
            return $query->date ? with(new Carbon($query->date))->format('d/m/Y') : '';
        })
        ->addColumn('DT_RowIndex', function($row) {
            static $index = 1;
            return $index++;
        })
        ->addColumn('action', 'petugas.actionLink')
        ->addColumn('nominal', function ($query) {
            return number_format($query->nominal, 2);
        })
        ->make(true);
    }

    public function petugas_table()
    {
        $petugas = MasterPetugas::all();
        return view('master.petugas', compact('petugas'));
    }

    public function petugas_store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        DB::beginTransaction();

        try {

            MasterPetugas::create([
                'name' => $request->name,
                'updated_by' => auth()->user()->id,
                'created_by' => auth()->user()->id,
            ]);

            DB::commit();
            return redirect()->route('petugasTable')->with('success', 'Data Tersimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', $e->getMessage());
        }
    }

    public function petugas_delete($id)
    {
        DB::beginTransaction();

        try {

            $get = MasterPetugas::findOrFail($id);
            $get->delete();

            DB::commit();
            return redirect()->route('petugasTable')->with('success', 'Data Terhapus');
        } catch(\Exception $e) {
            DB::rollback();
            return back()->with('failed', $e->getMessage());
        }
    }

    public function export_excel(Request $request)
    {
        $name = $request->name;
        $petugas = LaporanPetugas::whereHas('mPetugasId', function ($q) use ($name){
            $q->where('id', $name);
        })->with('mPetugasId:id,name')->get();

        return Excel::download(new LaporanPetugasExport($petugas), 'Data.xlsx');
    }
}
