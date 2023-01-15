<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB, Auth};

class DashboardController extends Controller
{
    public function dashboard()
    {
        return view('dashboard');
    }
}
