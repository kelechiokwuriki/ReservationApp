<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function viewSettingsPage()
    {
        return view('reservation.settings');
    }
}
