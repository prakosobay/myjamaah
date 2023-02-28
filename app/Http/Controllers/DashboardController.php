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
        // $saldo = Transaction::
        return view('home', compact('jamaah'));
    }

    public function getIslam()
    {
        $get = MasterReligion::where('name', 'islam')->first();
        return $get->id;
    }
}
