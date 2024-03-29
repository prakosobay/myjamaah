<?php

use App\Http\Controllers\{AuthController, CitizenController, DashboardController, EducationController, FamilyStatusController, JobController, KawasanController, LaporanPetugasController, ReligionController, ResidenceStatusController, RtRwController, SalaryController, SaldoKasController, SocialStatusController};
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['guest'])->group(function () {

    Route::get('/', function () {
        return view('auth.login');
    });

    Route::controller(AuthController::class)->group(function(){
        Route::post('login', 'login')->name('loginAuth');
    });
});

Route::middleware(['auth'])->group(function(){

    Route::controller(DashboardController::class)->group(function(){
        Route::get('dashboard', 'dashboard')->name('dashboard');
    });

    Route::controller(FamilyStatusController::class)->group(function(){
        Route::get('family-status/table', 'table')->name('familyStatusTable');
        Route::post('family-status/store', 'store')->name('familyStatusStore');
        Route::post('family-status/delete/{id}', 'delete')->name('familyStatusDelete');
    });

    Route::controller(RtRwController::class)->group(function(){
        Route::get('rtrw/table', 'table')->name('rtrwTable');
        Route::post('rtrw/store', 'store')->name('rtrwStore');
        Route::post('rtrw/delete/{id}', 'delete')->name('rtrwDelete');
    });

    Route::controller(ReligionController::class)->group(function(){
        Route::get('religion/table', 'table')->name('religionTable');
        Route::post('religion/store', 'store')->name('religionStore');
        Route::post('religion/delete/{id}', 'delete')->name('religionDelete');
    });

    Route::controller(SalaryController::class)->group(function(){
        Route::get('salary/table', 'table')->name('salaryTable');
        Route::post('sallary/store', 'store')->name('salaryStore');
        Route::post('sallary/delete/{id}', 'delete')->name('salaryDelete');
    });

    Route::controller(EducationController::class)->group(function(){
        Route::get('education/table', 'table')->name('educationTable');
        Route::post('education/store', 'store')->name('educationStore');
        Route::post('education/delete/{id}', 'delete')->name('educationDelete');
    });

    Route::controller(JobController::class)->group(function(){
        Route::get('job/table', 'table')->name('jobTable');
        Route::post('job/store', 'store')->name('jobStore');
        Route::post('job/delete/{id}', 'delete')->name('jobDelete');
    });

    Route::controller(ResidenceStatusController::class)->group(function(){
        Route::get('residence-status/table', 'table')->name('residenceStatusTable');
        Route::post('residence-status/store', 'store')->name('residenceStatusStore');
        Route::post('residence-status/delete/{id}', 'delete')->name('residenceStatusDelete');
    });

    Route::controller(SocialStatusController::class)->group(function(){
        Route::get('social-status/table', 'table')->name('socialStatusTable');
        Route::post('social-status/store', 'store')->name('socialStatusStore');
        Route::post('social-status/delete/{id}', 'delete')->name('socialStatusDelete');
    });

    Route::controller(CitizenController::class)->group(function(){
        Route::get('citizen/table', 'table')->name('citizenTable');
        Route::get('citizen/add', 'add')->name('citizenAdd');
        Route::get('citizen/view/{id}', 'view')->name('citizenView');
        Route::get('citizen/edit/{id}', 'edit')->name('citizenEdit');
        Route::post('citizen/store', 'store')->name('citizenStore');
        Route::post('citizen/update/{id}', 'update')->name('citizenUpdate');
        Route::post('citizen/delete/{id}', 'delete')->name('citizenDelete');
        Route::post('citizen/import', 'import')->name('citizenImport');
        Route::get('citizen/export', 'export')->name('citizenExport');
        Route::get('citizen/yajra', 'yajra')->name('yajraCitizen');
    });

    Route::controller(SaldoKasController::class)->group(function () {
        Route::post('saldo-kas/store', 'storeTransaction')->name('storeTransaction');
        Route::post('saldo-kas/filter', 'storeFilter')->name('storeFilter');
        Route::post('saldo-kas/delete/{id}', 'delete')->name('saldoKas.delete');
        Route::post('saldo-kas/update/{id}', 'update')->name('saldoKas.update');
        Route::get('saldo-kas/edit/{id}', 'edit')->name('saldoKas.edit');
        Route::get('saldo-kas/add', 'addTransaction')->name('addTransaction');
        Route::get('saldo-kas/table', 'tableTransaction')->name('tableTransaction');
        Route::get('saldo-kas/yajra', 'yajraTransaction')->name('yajraTransaction');
        Route::get('saldo-kas/total', 'totalSaldo')->name('totalSaldo');
        Route::get('saldo-kas/excel', 'exportExcel')->name('exportExcelSaldo');
    });

    Route::controller(LaporanPetugasController::class)->group(function () {
        Route::get('laporan/petugas/table', 'table')->name('tableLaporanPetugas');
        Route::get('laporan/petugas/yajra', 'yajra')->name('yajraLaporanPetugas');
        Route::get('petugas/table', 'petugas_table')->name('petugasTable');
        Route::get('laporan/petugas/edit/{id}', 'edit')->name('petugasEdit');

        Route::post('laporan/petugas/export/excel', 'export_excel')->name('laporanPetugas.exportExcel');
        Route::post('petugas/store', 'petugas_store')->name('petugasStore');
        Route::post('petugas/delete/{id}', 'petugas_delete')->name('petugasDelete');
        Route::post('laporan/petugas/update/{id}', 'update')->name('petugas.update');
        Route::post('laporan/petugas/delete/{id}', 'delete')->name('laporanPetugasDelete');
        Route::post('laporan-petugas/store', 'store')->name('storeLaporanPetugas');
    });

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});

Auth::routes();
