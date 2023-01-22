<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BesoinAideController extends Controller
{
    public function besoinAide(Request $request)
    {
        return view('besoinaide');
    }
}
