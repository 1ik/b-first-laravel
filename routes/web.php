<?php

use App\Http\Controllers\Api\ForgetPasswordController;
use App\Http\Controllers\Api\Frontend\AuthController;
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
Route::get('/login', function () {
    return view('login');
});
Route::get('/reset-password/{token}', [ForgetPasswordController::class, 'resetPassword'])->name('password.reset');
Route::post('/reset-password', [ForgetPasswordController::class, 'passwordStore'])->name('password.store');

Route::get('/auth/{provider}/redirect', [AuthController::class, 'redirect']);
Route::get('/auth/{provider}/callback', [AuthController::class, 'callback']);

Route::get('/activate-account/{user}', [AuthController::class,'activeUserAccount'])->name('active-user-account');
Route::get('/activation-success',  [AuthController::class,'showSuccess'])->name('activation-success');
