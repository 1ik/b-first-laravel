<?php

use App\Http\Controllers\api\ForgetPasswordController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/reset-password/{token}', [ForgetPasswordController::class, 'resetPassword'])->name('password.reset');
Route::post('/reset-password', [ForgetPasswordController::class, 'passwordStore'])->name('password.store');