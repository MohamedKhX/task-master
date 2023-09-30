<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function overview()
    {
        return view('dashboard.overview');
    }

    public function tasks()
    {
        return view('dashboard.tasks');
    }

    public function inbox()
    {
        //Todo: to return inbox view
    }
}
