<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
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

Route::get('/', [HomeController::class, 'index'])->name('index');

Route::controller(UserController::class)->group(function() {
    Route::get('/admin/user/list', 'list')->name('user.list');

    Route::get('/admin/user/create', 'create')->name('user.create');
    Route::post('/admin/user/store', 'store')->name('user.store');

    Route::get('/admin/user/show/{user}', 'show')->name('user.show');
    Route::get('/admin/user/edit/{user}', 'edit')->name('user.edit');
    Route::put('/admin/user/update/{user}', 'update')->name('user.update');
});
