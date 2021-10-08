<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\IncidentController;

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



Route::prefix('v1')->group(function () {

    Route::get    ('/incident',        [IncidentController::class, 'index']);
    Route::get    ('/incident/{id}',   [IncidentController::class, 'show']);
    Route::post   ('/incident',        [IncidentController::class, 'store']);
    Route::post   ('/incident/{id}',   [IncidentController::class, 'update']);
    Route::delete ('/incident/{id}',   [IncidentController::class, 'destroy']);

});