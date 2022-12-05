<?php

use App\Http\Controllers\AuthOtpController;
use App\Http\Controllers\ProfileController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function (){
    Route::get('/login', [AuthOtpController::class, 'index'])->name('login');
    Route::post('/otp/generate', [AuthOtpController::class, 'generate'])->name('otp.generate');
    Route::get('/otp/verification/{user_id}', [AuthOtpController::class, 'verification'])->name('otp.verification');
    Route::post('otp/login', [AuthOtpController::class, 'loginWithOtp'])->name('otp.login');

    Route::get('/dashboard', [ProfileController::class, 'index'])->name('dashboard');

});
