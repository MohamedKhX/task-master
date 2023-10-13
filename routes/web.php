<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\InboxController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TeamsController;
use Illuminate\Support\Facades\Route;
use Laravolt\Avatar\Facade as Avatar;

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

Route::redirect('/', '/dashboard');

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])
    ->group(function () {

        /* For Admins */
        Route::middleware(['role:admin'])->group(function () {
            Route::get('dashboard/employee', [EmployeesController::class, 'index'])->name('employee.index');
            Route::get('dashboard/team',     [TeamsController::class, 'index'])->name('team.index');
        });

        Route::get(       'dashboard',             DashboardController::class)->name('dashboard');
        Route::resource('dashboard/project',  ProjectController::class)->only('index', 'show');
        Route::get(       'dashboard/inbox',       InboxController::class)->name('inbox');
        Route::get(       'dashboard/employee/{employee:id}', [EmployeesController::class, 'show'])->name('employee.show');
});
