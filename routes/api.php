<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashbordController;
use App\Http\Controllers\GameDetailController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/baseball/dashbord', [DashbordController::class, 'index'])->name('baseball.dashbord');
Route::get('/baseball/{dating}/game_detail', [GameDetailController::class, 'index'])->name('baseball.game_detail');
Route::get('/baseball/game_detail/create', [GameDetailController::class, 'create'])->name('baseball.game_detail.create');
Route::post('/baseball/game_detail/store', [GameDetailController::class, 'store'])->name('baseball.game_detail.store');