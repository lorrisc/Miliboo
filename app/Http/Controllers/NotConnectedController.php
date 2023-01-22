<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotConnectedController extends Controller
{
    public function index()
    {
        return view('notconnected');
    }
}
