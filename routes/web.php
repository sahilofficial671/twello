<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\BoardController;

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

Route::group(["middleware" => ['auth']], function(){
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    Route::prefix('boards')->group(function () {
        Route::get('/{board_id}', [BoardController::class, 'show'])->name('boards.show');
    });
});
