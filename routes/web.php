<?php

use App\Http\Controllers\OrderController;
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

Route::get('/filter', 'FoodController@index')->name('filter');

Route::get('/admin', [OrderController::class, 'index'])->name('order.index');
Route::post('/store-table-data', [OrderController::class, 'store'])->name('order.store');
