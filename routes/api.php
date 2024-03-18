<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/joke', [DataController::class, 'joke']);
Route::get('/initials', [DataController::class, 'initials']);
Route::get('/mathcheck', [DataController::class, 'mathcheck']);
Route::get('/createdat', [DataController::class, 'createdat']);
