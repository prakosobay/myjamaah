<?php

use App\Http\Controllers\{AuthController, DashboardController, EducationController, FamilyStatusController, JobController, KawasanController, ReligionController, ResidenceStatusController, SalariesController};
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

Route::get('/', function () {
    return view('auth.login');
});

Route::controller(AuthController::class)->group(function(){
    Route::post('login', 'login')->name('loginAuth');
});

Route::controller(DashboardController::class)->group(function(){
    Route::get('dashboard', 'dashboard')->name('dashboard');
});

Route::controller(FamilyStatusController::class)->group(function(){
    Route::get('family-status/table', 'table')->name('familyStatusTable');
    Route::post('family-status/store', 'store')->name('familyStatusStore');
    Route::post('family-status/delete/{id}', 'delete')->name('familyStatusDelete');
});

Route::controller(KawasanController::class)->group(function(){
    Route::get('kawasan/table', 'table')->name('kawasanTable');
});

Route::controller(ReligionController::class)->group(function(){
    Route::get('religion/table', 'table')->name('religionTable');
    Route::post('religion/store', 'store')->name('religionStore');
    Route::post('religion/delete/{id}', 'delete')->name('religionDelete');
});

Route::controller(SalariesController::class)->group(function(){
    Route::get('salary/table', 'table')->name('salaryTable');
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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
