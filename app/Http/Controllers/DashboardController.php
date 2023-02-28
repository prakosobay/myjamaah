<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB, Auth};
use App\Models\{Citizen, MasterReligion, Transaction};

class DashboardController extends Controller
{
    public function dashboard()
    {
        $jamaah = Citizen::where('m_religion_id', $this->getIslam())->count();
        $pemasukan = $this->getIncome();
        $pengeluaran = $this->getExpense();
        $total = $this->getTotal();
        return view('home', compact('jamaah', 'pemasukan', 'pengeluaran', 'total'));
    }

    public function getIslam()
    {
        $get = MasterReligion::where('name', 'islam')->first();
        return $get->id;
    }

    public function getIncome()
    {
        $income = Transaction::where('type', 'Pemasukan')->sum('val');
        return $income;
    }

    public function getExpense()
    {
        $expense = Transaction::where('type', 'Pengeluaran')->sum('val');
        return $expense;
    }

    public function getTotal()
    {
        $total = $this->getIncome() - $this->getExpense();
        return $total;
    }
}
