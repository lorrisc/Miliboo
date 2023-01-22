<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CookiesPageInfoController extends Controller
{
    public function controllerCookiesInfoPage(Request $request)
    {
        return view('cookiesinformation');
    }
}
