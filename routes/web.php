<?php

use App\Http\Controllers\AdminMasterController;
use App\Http\Controllers\AuthController;
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

Route::controller(AuthController::class)->group(function(){
    Route::middleware('guest')->group(function(){
        Route::get('login', 'login')->name('login');
        Route::post('login', 'proses_login')->name('proses_login');
    
        Route::get('register', 'register')->name('register');
        Route::post('register', 'proses_register')->name('proses-register');
    });

    Route::prefix('freelance')->middleware('auth','verified')->group(function(){
        Route::get('register', 'register_freelance')->name('register-freelance');
        Route::post('register', 'proses_register_freelance')->name('proses-register-freelance');
    });
});

Route::controller(AuthController::class)->middleware('auth','unverified')->group(function(){
    Route::get('verify', 'verify_email')->name('verify-email');
    Route::post('verify', 'verify')->name('verify');
});

Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::controller(AdminMasterController::class)->prefix('master')->middleware('auth','verified')->group(function(){
    Route::get('/dashboard', 'dashboard')->name('dashboard-master');

    Route::get('/admin', 'view_admin')->name('view-admin');
    Route::post('/admin', 'create_admin')->name('create-admin');
    Route::put('/admin/{id}', 'update_admin')->name('update-admin');
    Route::delete('/admin/{id}', 'delete_admin')->name('delete-admin');
    Route::get('/get-admin', 'get_admin')->name('get-admin');
    Route::get('/get-admin/{id}', 'get_admin_id')->name('get-admin-id');
});

