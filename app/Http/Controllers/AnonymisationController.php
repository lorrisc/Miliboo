<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class Anonymisation extends Controller
{
    public function index()
    {
        DB::statement("anonymize_customer_data()");
    }
}

?>