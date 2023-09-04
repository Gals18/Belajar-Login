<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
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

Route::get('/form-login', [AuthController::class, 'login']);
Route::get('/form-register', [AuthController::class, 'register']);

Route::post('/aksi-register', [AuthController::class, 'aksiregister']);
Route::post('/aksi-login', [AuthController::class, 'aksilogin']);

Route::group(['middleware' => 'cekLogin'], function () {
    Route::get('/admin', [AuthController::class, 'index']);


    Route::get('/', [AuthController::class, 'index']);

    Route::get('/Dashboard', [DashboardController::class, 'index']);


    Route::get('/logout', [AuthController::class, 'destroy']);
});
