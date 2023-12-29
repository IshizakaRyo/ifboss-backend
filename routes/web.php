<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminiController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;

use App\Http\Controllers\DashbordController;
use App\Http\Controllers\GameDetailController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware groupTop. Now create something great!
|
*/

Route::get('/hello', [DashbordController::class, 'sample']);
Route::get('/baseball/dashbord', [DashbordController::class, 'index'])->name('baseball.dashbord');
Route::get('/baseball/{dating}/game_detail', [GameDetailController::class, 'index'])->name('baseball.game_detail');
Route::get('/baseball/game_detail/create', [GameDetailController::class, 'create'])->name('baseball.game_detail.create');
Route::post('/baseball/game_detail/store', [GameDetailController::class, 'store'])->name('baseball.game_detail.store');