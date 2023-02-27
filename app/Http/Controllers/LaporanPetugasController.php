<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLaporanPetugas;
use Illuminate\Http\Request;
use App\Models\{LaporanPetugas};
use Illuminate\Support\Facades\{DB};
use Yajra\DataTables\Datatables;
use Illuminate\Support\{Str, Carbon};

class LaporanPetugasController extends Controller
{
    public function table()
    {
        return view('petugas.table');
    }

    public function store(StoreLaporanPetugas $request)
    {
        DB::beginTransaction();

        try {

            $create = LaporanPetugas::create([
                'name' => $request->name,
                'duty' => $request->duty,
                'nominal' => $request->nominal,
                'created_by' => auth()->user()->id,
                'date' => $request->date,
            ]);

            DB::commit();
            return redirect()->route('tableLaporanPetugas')->with('success', 'Data Berhasil Tersimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', $e->getMessage());
        }
    }

    public function yajra()
    {
        $query = LaporanPetugas::with('createdBy:id,name')->orderBy('date', 'asc')->get();
        return Datatables::of($query)
        ->editColumn('date', function ($query) {
            return $query->date ? with(new Carbon($query->date))->format('d/m/Y') : '';
        })
        ->addColumn('DT_RowIndex', function($row) {
            static $index = 1;
            return $index++;
        })
        ->addColumn('nominal', function ($query) {
            return number_format($query->nominal, 2);
        })
        ->toJson();
    }
}
