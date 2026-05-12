<?php

namespace App\Http\Controllers\controlpanel;

use App\Http\Controllers\Controller;


class dashboardController extends Controller
{
    public function index()
    {
        return view('panel_control.dashboard');
    }
}
