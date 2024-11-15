<?php

use App\Http\Controllers\Household\ReadHouseholdController;
use App\Http\Controllers\Household\UpdateHouseholdController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return 'api success!';
});

Route::prefix('households')
    ->group(function () {
        Route::get('{householdId}', [ReadHouseholdController::class, '__invoke']);
        Route::put('{householdId}', [UpdateHouseholdController::class, '__invoke']);
    });
