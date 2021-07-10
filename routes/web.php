<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\TaskController;

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
        Route::get('/{board}', [BoardController::class, 'show'])->name('boards.show');
        Route::post('/{board_id}/task_users/{task_user_id}/tasks', [TaskController::class, 'store'])->name('tasks.submit');
        Route::put('/{board_id}/task_users/{task_user_id}/tasks/{task_id}', [TaskController::class, 'update'])->name('tasks.update');

        Route::delete('/{board_id}/task_users/{task_user_id}/tasks/{task_id}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    });
});
