<?php

use App\Http\Controllers\Auth\LoginController;
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

Route::middleware('auth')->group( function () {

    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/', function () {
        return 'Ingresaste';
    });
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

});

