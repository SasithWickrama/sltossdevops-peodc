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
    return view('welcome');
});

Route::get('{service_order_no}',  [App\Http\Controllers\Customer\CustomerFeedbackController::class, 'index'])->name('customer.index');
Route::post('cust/update',  [App\Http\Controllers\Customer\CustomerFeedbackController::class, 'update'])->name('customerUpdate');
Route::get('cust/reasons',  [App\Http\Controllers\Customer\CustomerFeedbackController::class, 'get_reasons'])->name('get.reasons');
