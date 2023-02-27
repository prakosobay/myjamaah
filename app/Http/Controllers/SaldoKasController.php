<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTransactionRequest;
use Illuminate\Support\Facades\{DB};
use App\Models\{Transaction};
use Yajra\Datatables\Datatables;
use Illuminate\Support\{Str, Carbon};
use Maatwebsite\Excel\Facades\Excel;
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
        return view('kas.table');
    }

    public function storeFilter(Request $request)
    {
        // dd($request->all());

        $getTransactions = Transaction::with('createdBy:id,name')->where('type', $request->filter_type)->whereBetween('date_trans', [$request->date_from, $request->date_to]);
        // dd($getTransactions);
        return $getTransactions;

    }

    public function yajraTransaction()
    {
        $query = Transaction::with('createdBy:id,name');
        return Datatables::of($query)
        ->addColumn('DT_RowIndex', function($row) {
            static $index = 1;
            return $index++;
        })
        ->editColumn('date_trans', function ($getTransactions) {
            return $getTransactions->date_trans ? with(new Carbon($getTransactions->date_trans))->format('d/m/Y') : '';
        })
        ->toJson();
    }
}
