<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminMasterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\FreelanceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WilayahController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Callback\CallbackController;
use App\Http\Controllers\UserController;

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
        Route::post('register', 'proses_register')->name('proses_register');

        Route::get('forgot', 'forgot')->name('forgot');
        Route::post('forgot', 'reset_password')->name('reset_password');
        Route::post('send_reset_token', 'send_reset_token')->name('send_reset_token');
        Route::post('send_verify_token', 'send_verify_token')->name('send_verify_token');
    });

    Route::prefix('freelance')->middleware(['auth', 'checkSuspend', 'verified'])->group(function(){
        Route::get('register', 'register_freelance')->name('register-freelance');
        Route::post('register', 'proses_register_freelance')->name('proses-register-freelance');
        Route::put('register', 'register_update_freelance')->name('register_update_freelance');
    });
});

Route::controller(AuthController::class)->middleware(['auth', 'checkSuspend', 'unverified'])->group(function(){
    Route::get('verify', 'verify_email')->name('verification.notice');
    Route::post('verify', 'verify')->name('verify');
});

Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::controller(AdminMasterController::class)->prefix('master')->middleware(['auth', 'checkSuspend', 'check:Master', 'verified'])->group(function(){
    Route::get('/', 'dashboard')->name('dashboard-master');

    Route::get('admin', 'view_admin')->name('view_admin');
    Route::post('admin', 'create_admin')->name('create_admin');
    Route::put('admin/{id}', 'update_admin')->name('update_admin');
    Route::delete('admin/{id}', 'delete_admin')->name('delete_admin');
    Route::get('get-admin', 'get_admin')->name('get_admin');
    Route::get('get-admin/{id}', 'get_admin_id')->name('get_admin_id');
    
    Route::get('website-conf', 'view_website_conf')->name('view-website-conf');
    Route::put('update_website_conf', 'update_website_conf')->name('update_website_conf');
    Route::put('update_payment_gateway', 'update_payment_gateway')->name('update_payment_gateway');
    Route::put('update_kontak', 'update_kontak')->name('update_kontak');
    Route::put('update_web_profit', 'update_web_profit')->name('update_web_profit');

    Route::get('tokopay/get','get_tokopay')->name('get_tokopay');

    Route::prefix('payment_channel')->group(function(){
        Route::get('', 'view_payment_channel')->name('view_payment_channel');
        Route::post('', 'create_payment_channel')->name('create_payment_channel');
        Route::put('{id}', 'update_payment_channel')->name('update_payment_channel');
        Route::delete('{id}', 'delete_payment_channel')->name('delete_payment_channel');

        Route::get('/get', 'get_payment_channel')->name('get_payment_channel');
        Route::get('/get/{id}', 'get_payment_channel_id')->name('get_payment_channel_id');
    });

    Route::prefix('profit')->group(function(){
        Route::get('', 'view_profit')->name('view_profit');
        Route::get('/get', 'get_profit')->name('get_profit');
        Route::get('/chart', 'profit_chart')->name('profit_chart');
    });
});

Route::controller(AdminController::class)->prefix('admin')->middleware(['auth', 'checkSuspend', 'check:Admin', 'verified'])->group(function(){
    Route::get('/', 'dashboard')->name('dashboard-admin');
    Route::get('/get/catalog_chart', 'catalog_chart')->name('catalog_chart');
    Route::get('/get/transaction_chart', 'transaction_chart')->name('transaction_chart');

    Route::prefix('data')->group(function(){
        Route::get('/catalog', 'data_catalog')->name('data_catalog');
        Route::post('/toggle_status', 'toggle_status')->name('toggle_status');
        Route::get('/catalog/get', 'get_data_catalog')->name('get_data_catalog');
        Route::get('/catalog/pdf', 'pdf_data_catalog')->name('pdf_data_catalog');
    });

    Route::prefix('withdraw')->group(function(){
        Route::get('/', 'view_withdraw')->name('view_withdraw_admin');
        Route::get('/get', 'get_withdraw')->name('get_withdraw_admin');
        Route::post('/approve/{id}', 'withdraw_approve')->name('withdraw_approve');
        Route::post('/reject/{id}', 'withdraw_reject')->name('withdraw_reject');
    });

    Route::prefix('freelance')->group(function(){
        Route::get('','view_freelance')->name('view_freelance');
        Route::get('/get','get_freelance')->name('get_freelance');
        Route::get('/edit/{id}', 'edit_freelance')->name('edit_freelance');
        Route::put('/update/{id}', 'update_freelance')->name('update_freelance');
        Route::delete('/delete/{id}', 'delete_freelance')->name('delete_freelance');

        Route::get('validasi', 'view_validasi_freelance')->name('view-validasi-freelance');
        Route::put('validasi/approve/{id}', 'update_validasi_freelance')->name('update-validasi-freelance');
        Route::put('validasi/reject/{id}', 'reject_freelance')->name('reject_freelance');
        Route::get('get-validasi-freelance', 'get_validasi_freelance')->name('get-validasi-freelance');
        
        Route::get('kelola', 'view_kelola_freelance')->name('view-kelola-freelance');
        Route::get('get-kelola-freelance', 'get_kelola_freelance')->name('get-kelola-freelance');

        Route::get('get-freelance/{id}', 'get_freelance_id')->name('get-freelance-id');
    });

    Route::prefix('user')->group(function(){
        Route::get('','view_user')->name('view_user');
        Route::get('/get','get_user')->name('get_user');
        Route::get('/edit/{id}', 'edit_user')->name('edit_user');
        Route::put('/update/{id}', 'update_user')->name('update_user');
        Route::delete('/delete/{id}', 'delete_user')->name('delete_user');

        Route::get('suspend', 'view_suspend')->name('view_suspend');
        Route::get('get_suspend', 'get_suspend')->name('get_suspend');
        Route::delete('unblock_user', 'unblock_user')->name('unblock_user');
        Route::post('block_user', 'block_user')->name('block_user');

        Route::get('suspend_request', 'view_suspend_request')->name('view_suspend_request');
        Route::get('get_suspend_request', 'get_suspend_request')->name('get_suspend_request');
    });

    Route::prefix('category')->group(function(){
        Route::get('', 'view_category')->name('view_category');
        Route::post('', 'create_category')->name('create_category');
        Route::put('{id}', 'update_category')->name('update_category');
        Route::delete('{id}', 'delete_category')->name('delete_category');

        Route::get('/get', 'get_category')->name('get_category');
        Route::get('/get/{id}', 'get_category_id')->name('get_category_id');
    });
});

Route::controller(UserController::class)->prefix('user')->middleware(['auth', 'checkSuspend', 'check:User', 'verified'])->group(function(){
    Route::get('/', 'dashboard')->name('dashboard_user');

    Route::prefix('transaction')->group(function(){
        Route::get('/', 'view_transaction')->name('view_transaction_user');
        Route::get('/get', 'get_transaction')->name('get_transaction_user');
    });

    Route::prefix('profile')->group(function(){
        Route::get('/', 'view_profile')->name('view_profile_user');
        Route::put('/', 'update_profile')->name('update_profile_user');
    });
});

Route::controller(HomeController::class)->middleware('checkSuspend')->group(function(){
    Route::get('/', 'home')->name('home');

    Route::prefix('catalog')->group(function(){
        Route::get('search/{search}', 'search')->name('search');
        Route::get('get/{search}', 'get_catalog')->name('get_catalog');
        Route::get('get/fillter', 'get_filtered_catalog')->name('get_filtered_catalog');
        
        Route::prefix('wishlist')->middleware(['auth', 'checkSuspend', 'verified'])->group(function(){
            Route::get('/', 'view_wishlist')->name('view-wishlist');
            Route::post('add', 'add_wishlist')->name('add-wishlist');
            Route::post('remove', 'remove_wishlist')->name('remove-wishlist');
        });
    
        Route::get('{username}/{slug}', 'view_catalog')->name('view-catalog');
    });
});

Route::controller(FreelanceController::class)->prefix('freelance')->middleware(['auth', 'checkSuspend', 'check:Freelance', 'verified'])->group(function(){
    Route::get('/', 'dashboard')->name('dashboard-freelance');

    Route::prefix('/catalog')->group(function(){
        Route::get('/', 'catalog')->name('catalog-freelance');
        Route::get('create', 'view_catalog')->name('view-create-catalog-freelance');
        Route::post('create', 'create_catalog')->name('create-catalog-freelance');

        Route::get('{id}/update','edit_catalog')->name('edit-catalog');
        Route::put('{id}/update','update_catalog')->name('update_catalog_freelance');
    });

    Route::prefix('/transaction')->group(function(){
        Route::get('/', 'view_transaction')->name('view_transaction_freelance');
        Route::get('/get', 'get_transaction')->name('get_transaction_freelance');

        Route::post('/approved', 'approved_transaction')->name('approved_transaction_freelance');
    });

    Route::prefix('/feedback')->group(function(){
        Route::get('/', 'view_feedback')->name('view_feedback_freelance');
    });

    Route::prefix('/withdraw')->group(function(){
        Route::get('/', 'view_withdraw')->name('view_withdraw_freelance');
        Route::get('/get', 'get_withdraw')->name('get_withdraw_freelance');

        Route::post('/', 'withdraw_balance')->name('withdraw_balance_freelance');
    });

    Route::prefix('profile')->group(function(){
        Route::get('/', 'view_profile')->name('view_profile_freelance');
        Route::put('/', 'update_profile')->name('update_profile_freelance');
    });
    
    Route::get('calendar', 'calendar')->name('freelance-calendar');
    Route::get('calendar/get', 'get_calendar')->name('get-calendar');
    Route::get('calendar/get/{id}', 'get_calendar_id')->name('get-calendar-id');
    Route::post('calendar', 'create_calendar')->name('freelance-create-calendar');
    Route::put('calendar/{id}', 'update_calendar')->name('freelance-update-calendar');
    Route::delete('calendar/{id}', 'delete_calendar')->name('freelance-delete-calendar');
});

Route::controller(TransactionController::class)->prefix('transaction')->middleware(['auth', 'checkSuspend', 'verified'])->group(function(){
    Route::get('/invoice/{invoice}', 'view_transaction')->name('view_transaction');
    Route::post('/create', 'create_transaction')->name('create_transaction');
    Route::put('/update/{invoice}', 'update_transaction')->name('update_transaction');

    Route::post('/create/payment', 'create_payment')->name('create_payment');
    Route::post('/create/feedback', 'create_feedback')->name('create_feedback');

    Route::get('/payment/detail/{invoice}', 'payment_detail')->name('payment_detail');
    Route::get('/transaction/detail/{invoice}', 'transaction_detail')->name('transaction_detail');
    Route::get('/transaction/timeline/{id}','transaction_timeline')->name('transaction_timeline');
    Route::post('/transaction/timeline/{id}','create_transaction_timeline')->name('create_transaction_timeline');
});

Route::controller(MessageController::class)->prefix('message')->middleware(['auth', 'checkSuspend', 'verified'])->group(function(){
    Route::get('/', 'view_message')->name('view_message');
    Route::get('{user}', 'message_user')->name('message_user');
    Route::post('send', 'message_send')->name('message_send');
    Route::post('/report_user', 'report_user')->name('report_user');
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

Route::controller(CallbackController::class)->group(function(){
    Route::post('callback/tokopay', 'tokopay')->name('tokopay-callback');
});

// Untuk Storge Link
// Route::get('link', function (){

//     $target = $_SERVER['DOCUMENT_ROOT']."/../laravel/storage/app/public/";
//     $link = $_SERVER['DOCUMENT_ROOT']."/storage";

//     // Check if symlink or file already exists
//     if (!file_exists($link) && !is_link($link)) {

//         // Attempt to create symlink
//         if (symlink($target, $link)) {
//             echo "OK.";
//         } else {
//             echo "Gagal.";
//         }

//     } else {
//         echo "Symlink atau file sudah ada.";
//     }

// });