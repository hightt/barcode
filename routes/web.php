<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarcodeController;
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

Route::resource('/barcode', Barcodecontroller::class);
Route::get('/', [Barcodecontroller::class, 'index']);
Route::post('/generateWebpBarcode', [Barcodecontroller::class, 'generateWebpBarcode']);
