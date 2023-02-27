<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{DB};
use App\Models\{SaldoKas};
use Illuminate\Http\Request;

class SaldoKasController extends Controller
{
    public function getUser()
    {
        $auth = auth()->user()->id;
        return $auth;
    }

    public function storeKeluar(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'duit' => ['required', 'numeric'],
            'note' => ['required', 'string', 'max:255'],
        ]);

        DB::beginTransaction();

        try {

            $create = SaldoKas::create([
                'duit' => $request->duit,
                'note' => $request->note,
                'is_income' => false,
                'updated_by' => $this->getUser(),
                'created_by' => $this->getUser(),
            ]);
            // dd($create);
            DB::commit();
            return redirect()->route('kasKeluarView')->with('success', 'Data Tersimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function storeMasuk(Request $request)
    {
        $request->validate([
            'duit' => ['required', 'numeric'],
            'note' => ['required', 'string', 'max:255'],
        ]);

        DB::beginTransaction();

        try {

            $create = SaldoKas::create([
                'duit' => $request->duit,
                'note' => $request->note,
                'is_income' => true,
                'updated_by' => $this->getUser(),
                'created_by' => $this->getUser(),
            ]);
            // dd($create);
            DB::commit();
            return redirect()->route('kasMasukView')->with('success', 'Data Tersimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function kasMasuk()
    {
        $masuk = SaldoKas::with(['updatedBy:id,name', 'createdBy:id,name'])->where('is_income', 1)->get();
        return view('kas.masuk', compact('masuk'));
    }

    public function kasKeluar()
    {
        $keluar = SaldoKas::with(['updatedBy:id,name', 'createdBy:id,name'])->where('is_income', 0)->get();
        return view('kas.keluar', compact('keluar'));
    }
}
