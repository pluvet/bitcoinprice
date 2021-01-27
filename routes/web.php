<?php

use App\Http\Controllers\BitcoinController;
use App\Http\Controllers\ConsultaController;
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

Route::get('bitcoin/{start}/{end}', [BitcoinController::class, 'show']);

Route::get('consultas/bitcoin', [ConsultaController::class, 'show']);
