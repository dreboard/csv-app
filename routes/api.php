<?php

use App\Http\Controllers\V1\ContactsController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\SearchContactsController;
use Illuminate\Support\Facades\Route;

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
Route::post('/store', [FileController::class, 'store']);

Route::group(['prefix' => 'V1'], function () {
    Route::post('/date_range', [SearchContactsController::class, 'dateRange']);
    Route::apiResource('/contacts', ContactsController::class);
});
