<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\ClinicaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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


Route::get('login', [LoginController::class, 'showLoginForm']);
Route::post('login', [LoginController::class, 'login'])->name('login');

Route::middleware(['auth', 'admin'])->group( function () {

    Route::resource('usuarios', UserController::class);

    Route::resource('clinicas', ClinicaController::class);

    Route::get('horarios/{id}/create', [HorarioController::class, 'create'])->name('horarios.create');
    Route::post('horarios', [HorarioController::class, 'store'])->name('horarios.store');
    Route::delete('horarios/{id}/destroy', [HorarioController::class, 'destroy'])->name('horarios.destroy');

});

Route::middleware('auth')->group( function () {

    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::resource('citas', CitaController::class);

    Route::get('horarios/horas', [HorarioController::class, 'hours']);

    //Route::get('horarios/{clinica_id}/{fecha}')


});

