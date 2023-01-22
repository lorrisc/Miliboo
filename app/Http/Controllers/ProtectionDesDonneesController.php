<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProtectionDesDonneesController extends Controller
{
    public function protectiondesdonnees(){
        return view('protectiondesdonnees');
    }
}
