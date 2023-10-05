<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect(\route('dashboard'));
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])
    ->group(function () {
        Route::get('dashboard', [DashboardController::class, 'overview'])->name('dashboard');
        Route::get('dashboard/tasks', [DashboardController::class, 'tasks'])->name('tasks');

        Route::resource('dashboard/project', ProjectController::class);
});

Route::view('/dashboard/users/create', 'dashboard.admin.users.create');
Route::view('/dashboard/profile', 'profile.show');
