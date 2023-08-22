<?php

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
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

#HOME

Route::prefix('home')->middleware(['auth'])->group(function () {

    # Usuario
    Route::controller(App\Http\Controllers\Admin\UserController::class)->group(function () {
        Route::get('/user/profile', 'profile');
        Route::put('/user/profile/{user}', 'profile_update');
    });

    # Mantenimiento
    Route::controller(App\Http\Controllers\Admin\MaintenanceController::class)->group(function () {
        Route::get('/maintenance', 'index');
        Route::get('/maintenance/create', 'create');
        Route::post('/maintenance', 'store');
        Route::get('/maintenance/{maintenance}/show', 'show');
        Route::get('/maintenance/{maintenance}/edit', 'edit');
        Route::post('/maintenance/delete', 'destroy')->name('destroy_maintenance');
        Route::put('/maintenance/{maintenance}', 'update');
        Route::get('/maintenance/list_ajax_maintenance', 'list_ajax')->name('list_ajax_maintenance');
        Route::get('/maintenance/whatsapp', 'sendWhatsAppMessage');
    });

});


# ADMIN
Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function () {

    Route::get('dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index']);

    # Usuario
    Route::controller(App\Http\Controllers\Admin\UserController::class)->group(function () {
        Route::get('/user', 'index');
        Route::get('/user/create', 'create');
        Route::post('/user', 'store');
        Route::get('/user/{user}/show', 'show');
        Route::get('/user/{user}/edit', 'edit');
        Route::post('/user/delete', 'destroy')->name('destroy_user');
        Route::put('/user/{user}', 'update');
        Route::get('/user/list_ajax_user', 'list_ajax')->name('list_ajax_user');
    });
});