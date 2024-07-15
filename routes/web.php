<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminMasterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\FreelanceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\WilayahController;
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

Route::controller(AdminMasterController::class)->prefix('master')->middleware('check:Master','auth','verified')->group(function(){
    Route::get('/', 'dashboard')->name('dashboard-master');

    Route::get('admin', 'view_admin')->name('view-admin');
    Route::post('admin', 'create_admin')->name('create-admin');
    Route::put('admin/{id}', 'update_admin')->name('update-admin');
    Route::delete('admin/{id}', 'delete_admin')->name('delete-admin');
    Route::get('get-admin', 'get_admin')->name('get-admin');
    Route::get('get-admin/{id}', 'get_admin_id')->name('get-admin-id');

    Route::get('website-conf', 'view_website_conf')->name('view-website-conf');
    Route::put('website-conf', 'update_website_conf')->name('update-website-conf');
});

Route::controller(AdminController::class)->prefix('admin')->middleware('check:Admin','auth','verified')->group(function(){
    Route::get('/', 'dashboard')->name('dashboard-admin');

    Route::prefix('freelance')->group(function(){
        Route::get('validasi', 'view_validasi_freelance')->name('view-validasi-freelance');
        Route::put('validasi/{id}', 'update_validasi_freelance')->name('update-validasi-freelance');
        Route::get('get-validasi-freelance', 'get_validasi_freelance')->name('get-validasi-freelance');
        
        Route::get('kelola', 'view_kelola_freelance')->name('view-kelola-freelance');
        Route::get('get-kelola-freelance', 'get_kelola_freelance')->name('get-kelola-freelance');

        Route::get('get-freelance/{id}', 'get_freelance_id')->name('get-freelance-id');
    });
});

Route::controller(HomeController::class)->group(function(){
    Route::get('/', 'home')->name('home');

    Route::prefix('catalog')->group(function(){
        Route::get('category/{category}', 'search_category')->name('search-category');
        Route::get('search/{search}', 'search_catalog')->name('search-catalog');
        
        Route::prefix('wishlist')->middleware('auth','verified')->group(function(){
            Route::get('/', 'view_wishlist')->name('view-wishlist');
            Route::post('add', 'add_wishlist')->name('add-wishlist');
            Route::post('remove', 'remove_wishlist')->name('remove-wishlist');
        });
    
        Route::get('{username}/{slug}', 'view_catalog')->name('view-catalog');
    });
});

Route::controller(FreelanceController::class)->prefix('freelance')->middleware('check:Freelance','auth','verified')->group(function(){
    Route::get('/', 'dashboard')->name('dashboard-freelance');

    Route::prefix('/catalog')->group(function(){
        Route::get('/', 'catalog')->name('catalog-freelance');
        Route::get('create', 'view_catalog')->name('view-create-catalog-freelance');
        Route::post('create', 'create_catalog')->name('create-catalog-freelance');

        Route::get('{id}/update','edit_catalog')->name('edit-catalog');
    });
    
    Route::get('calendar', 'calendar')->name('freelance-calendar');
    Route::get('calendar/get', 'get_calendar')->name('get-calendar');
    Route::get('calendar/get/{id}', 'get_calendar_id')->name('get-calendar-id');
    Route::post('calendar', 'create_calendar')->name('freelance-create-calendar');
    Route::put('calendar/{id}', 'update_calendar')->name('freelance-update-calendar');
    Route::delete('calendar/{id}', 'delete_calendar')->name('freelance-delete-calendar');
});

Route::controller(MessageController::class)->prefix('message')->middleware('auth','verified')->group(function(){
    Route::get('/', 'view_message')->name('view_message');
    Route::get('{user}', 'message_user')->name('message_user');
    Route::post('send', 'message_send')->name('message_send');
});

Route::controller(CalendarController::class)->prefix('calendar')->group(function(){
    Route::get('{user}', 'view_calendar')->name('view_calendar');
    Route::get('get/{user}', 'get_calendar_by_id')->name('get_calendar_by_id');
});

Route::controller(WilayahController::class)->prefix('wilayah')->group(function(){
    Route::get('provinsi', 'provinces')->name('wilayah-provinsi');
    Route::get('kota/{id}', 'cities')->name('wilayah-kota');
    Route::get('kecamatan/{id}', 'districts')->name('wilayah-kecamatan');
    Route::get('desa/{id}', 'villages')->name('wilayah-desa');
});