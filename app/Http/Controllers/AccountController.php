<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class AccountController extends Controller
{
    public function index()
    {
        //$account_id =  Session::get('account_id');
        //$account = DB::table('compte_clients')->where('id', $account_id)->first();

        //Session::put('account_firstname', $account->prenom);






        return view('account');
    }
}
