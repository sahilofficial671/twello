<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskUserController;

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
        // Boards
        Route::get('/{board}', [BoardController::class, 'show'])->name('boards.show');
        Route::post('/submit', [BoardController::class, 'store'])->name('boards.store');

        // Task Users
        Route::prefix('/{board_id}/task_users')->name('task_users')->group(function () {
            Route::post('/', [TaskUserController::class, 'store'])->name('.submit');
            Route::get('/{task_users_id}', [TaskUserController::class, 'show'])->name('.show');
            Route::put('/{task_users_id}', [TaskUserController::class, 'update'])->name('.update');
            Route::delete('/{task_users_id}', [TaskUserController::class, 'destroy'])->name('.destroy');
        });


        // Tasks
        Route::prefix('/{board_id}/task_users/{task_users_id}/tasks')->name('tasks')->group(function () {
            Route::post('/', [TaskController::class, 'store'])->name('.submit');
            Route::put('/{task_id}/toggle', [TaskController::class, 'toggle'])->name('.toggle');
            Route::put('/{task_id}', [TaskController::class, 'update'])->name('.update');
            Route::delete('/{task_id}', [TaskController::class, 'destroy'])->name('.destroy');
        });
    });
});
