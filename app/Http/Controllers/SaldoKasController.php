<?php

namespace App\Http\Controllers;

use App\Exports\SaldoExport;
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

    public function yajraTransaction(Request $request)
    {
        if(request()->ajax()) {
            $query = Transaction::with('createdBy:id,name');

            if(!empty($request->from_date) && (!empty($request->to_date))) {

                if($request->type == 'Pengeluaran') {

                    $query = $query->where('type', 'Pengeluaran')->whereBetween('date_trans', [$request->from_date, $request->to_date]);
                } else if($request->type == 'Pemasukan') {

                    $query = $query->where('type', 'Pemasukan')->whereBetween('date_trans', [$request->from_date, $request->to_date]);
                } else {

                    $query = $query->whereBetween('date_trans', [$request->from_date, $request->to_date]);
                }
            }

            return Datatables::of($query)
            ->addColumn('DT_RowIndex', function($row) {
                static $index = 1;
                return $index++;
            })
            ->editColumn('val', function($getTransactions) {
                return $getTransactions->val ? number_format($getTransactions->val) : '';
            })
            ->editColumn('date_trans', function ($getTransactions) {
                return $getTransactions->date_trans ? with(new Carbon($getTransactions->date_trans))->format('d-m-Y') : '';
            })
            ->toJson();
        }
    }

    public function totalSaldo(Request $request)
    {
        if(request()->ajax()) {

            $query = Transaction::groupBy('type')
                ->selectRaw('sum(val) as total, type as type_transaction');

            if(!empty($request->from_date) && (!empty($request->to_date))) {

                if($request->type == 'Pengeluaran') {

                    $query = $query->where('type', 'Pengeluaran')->whereBetween('date_trans', [$request->from_date, $request->to_date]);

                } else if($request->type == 'Pemasukan') {

                    $query = $query->where('type', 'Pemasukan')->whereBetween('date_trans', [$request->from_date, $request->to_date]);

                } else {

                    $query = $query->whereBetween('date_trans', [$request->from_date, $request->to_date]);
                }
            }

            return  response()->json($query->get());
        }
    }

    public function exportExcel(Request $request)
    {
        if(request()->ajax()) {

            $query = Transaction::select('transactions.date_trans', 'transactions.type', 'transactions.name', 'transactions.val', 'users.name as createdby')->join('users', 'transactions.created_by', '=', 'users.id');

            if(!empty($request->from_date) && (!empty($request->to_date))) {

                if($request->type == 'Pengeluaran') {

                    $query = $query->where('type', 'Pengeluaran')->whereBetween('date_trans', [$request->from_date, $request->to_date])->get();
                } else if($request->type == 'Pemasukan') {

                    $query = $query->where('type', 'Pemasukan')->whereBetween('date_trans', [$request->from_date, $request->to_date])->get();
                } else {

                    $query = $query->whereBetween('date_trans', [$request->from_date, $request->to_date])->get();
                }
            }

            return Excel::download(new SaldoExport($query), 'List Data Transaksi.xlsx');
        }
    }
}
