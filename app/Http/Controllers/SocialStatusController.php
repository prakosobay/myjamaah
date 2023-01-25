<?php

namespace App\Http\Controllers;

use App\Models\MasterSocialStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB};

class SocialStatusController extends Controller
{
    public function table()
    {
        $socialStatuses = MasterSocialStatus::with(['createdBy:id,name', 'updatedBy:id,name'])->orderBy('name', 'asc')->get();
        return view('master.socialStatus', compact('socialStatuses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        DB::beginTransaction();

        try {

            MasterSocialStatus::firstOrCreate([
                'name' => $request->name,
                'updated_by' => auth()->user()->id,
                'created_by' => auth()->user()->id,
            ]);

            DB::commit();
            return redirect()->route('socialStatusTable')->with('success', 'Data Berhasil di Tambah');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', $e->getMessage());
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {

            $get = MasterSocialStatus::findOrFail($id);
            $get->delete();

            DB::commit();
            return redirect()->route('socialStatusTable')->with('success', 'Data Berhasil di Hapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', $e->getMessage());
        }
    }
}
