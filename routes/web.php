<?php

use App\Http\Controllers\GeneratePdfController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SubscriptionController;
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
    $path_user = '/admin/user/';
    Route::get($path_user . 'list', 'list')->name('user.list');
    Route::get($path_user . 'create', 'create')->name('user.create');
    Route::post($path_user . 'store', 'store')->name('user.store');
    Route::get($path_user . 'show/{user}', 'show')->name('user.show');
    Route::get($path_user . 'edit/{user}', 'edit')->name('user.edit');
    Route::put($path_user . 'update/{user}', 'update')->name('user.update');
    Route::post($path_user . 'import', 'import')->name('user.import');
});

Route::controller(InvoiceController::class)->group(function() {
    $path_invoice = '/admin/invoice/';
    Route::get($path_invoice . 'list', 'list')->name('invoice.list');
    Route::get($path_invoice . 'create', 'create')->name('invoice.create');
    Route::post($path_invoice . 'store', 'store')->name('invoice.store');
    Route::get($path_invoice . 'show/{invoice}', 'show')->name('invoice.show');
    Route::get($path_invoice . 'create-massive', 'createMassive')->name('invoice.create_massive');
    Route::post($path_invoice . 'create-invoices-list-by-user/{user}', 'createInvoicesByUser')->name('invoice.create_invoice_by_user');
});

Route::controller(PaymentController::class)->group(function () {
    $path_payment = '/admin/payment/';
    Route::get($path_payment . 'list', 'list')->name('payment.list');
    Route::get($path_payment . 'show/{payment}', 'show')->name('payment.show');
    Route::put($path_payment . 'payment/{invoice}', 'payment')->name('payment.invoice');
});

Route::controller(SubscriptionController::class)->group(function () {
   $subscription_path = '/admin/service/';
   Route::post($subscription_path . 'delete', 'delete')->name('service.delete');
   Route::get($subscription_path . '{userId}/services', 'getServicesByUser');
});

Route::controller(GeneratePdfController::class)->group(function () {
   Route::get('/admin/generate-massive-invoice-pdf', 'generateMassiveInvoicePdf')->name('massive_invoice.pdf');
   Route::get('/admin/generate-account-status-by-user-pdf/{user}', 'generateAccountStatusByUser')->name('pdf.account_status_by_user');
});
