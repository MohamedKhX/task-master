<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeesController extends Controller
{
    public function index()
    {
        return view('dashboard.employees.index');
    }

    public function destroy(Employee $employee)
    {
     //   dump($employee->name);
    }
}
