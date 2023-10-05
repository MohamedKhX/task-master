<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\ProjectController;
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

Route::get('/', function () {
    return redirect(\route('dashboard'));
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])
    ->group(function () {
        Route::get('dashboard', [DashboardController::class, 'overview'])->name('dashboard');
        Route::get('dashboard/tasks', [DashboardController::class, 'tasks'])->name('tasks');

        Route::resource('dashboard/project', ProjectController::class);
        Route::resource('dashboard/employee', EmployeesController::class);
});

Route::view('/dashboard/employees/create', 'dashboard.admin.employees.create');

/*
Route::get('/dashboard/employee', function() {

    dump(Avatar::create('Susilo Bambang Yudhoyono')->save('sample.png'));
    $employee = \App\Models\Employee::first();

    return view('employee.show', [
        'employee' => $employee
    ]);
});*/
