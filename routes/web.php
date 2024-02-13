<?php

use App\Http\Controllers\Api\User\Auth\PasswordResetTokenAPIController;
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
Route::get('/reset-password/{token}', [PasswordResetTokenAPIController::class, 'showResetPasswordPage'])->name('reset_password');

Route::get('/', function () {
    return view('welcome');
});
