<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTransactionRequest;
use Illuminate\Support\Facades\{DB};
use App\Models\{Transaction};
use Illuminate\Http\Request;

class SaldoKasController extends Controller
{
    public function getUser()
    {
        $auth = auth()->user()->id;
        return $auth;
    }

    public function addTransaction()
    {
        return view('kas.tambah');
    }

    public function storeTransaction(StoreTransactionRequest $request)
    {
        $data = $request->all();
        // dd($data);
        DB::beginTransaction();

        try {

            foreach($data['type'] as $p => $q) {

                if(isset($data['type'][$p])) {

                    Transaction::create([
                        'date_trans' => $request->date,
                        'type' => $data['type'][$p],
                        'name' => $data['name'][$p],
                        'val' => $data['val'][$p],
                        'created_by' => $this->getUser(),
                    ]);
                }
            }

            DB::commit();
            return back()->with('success', 'Berhasil di Tersimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function tableTransaction()
    {
        // $getAll = Transaction::with('createdBy:id,name')->get();
        return view('kas.table');
    }

    public function storeFilter(Request $request)
    {
        // dd($request->all());

        $getTransactions = Transaction::with('createdBy:id,name')->where('type', $request->filter_type)->whereBetween('date_trans', [$request->date_from, $request->date_to]);
        dd($getTransactions);

    }
}
