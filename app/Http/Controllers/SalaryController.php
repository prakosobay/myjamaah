<?php

namespace App\Http\Controllers;

use App\Models\MasterSalary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB};

class SalaryController extends Controller
{
    public function table()
    {
        $salaries = MasterSalary::with(['updatedBy:id,name', 'createdBy:id,name'])->orderBy('range', 'asc')->get();
        return view('master.salary', compact('salaries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mulai' => ['required'],
            'sampai' => ['nullable'],
        ]);

        DB::beginTransaction();

        try {

            $e = MasterSalary::create([
                'range' => $request->mulai . ' ' . '-' . ' ' . $request->sampai,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);

            DB::commit();
            return redirect()->route('salaryTable')->with('success', 'Data Berhasil di Tambah');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', $e->getMessage());
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {

            $get = MasterSalary::findOrFail($id);
            $get->delete();

            DB::commit();
            return redirect()->route('salaryTable')->with('success', 'Data Berhasil di Hapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', $e->getMessage());
        }
    }
}
