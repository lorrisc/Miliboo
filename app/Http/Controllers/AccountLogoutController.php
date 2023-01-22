<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class accountLogoutController extends Controller
{
    public function logout()
    {
        /*Session::forget('account_firstname');

        Session::forget('account_id');
        Session::forget('account_name');
        Session::forget('account_ville_id');
        Session::forget('account_civilite_id');
        Session::forget('account_code_postal_id');
        Session::forget('account_email');
        Session::forget('account_password');
        Session::forget('account_adresse_client');
        Session::forget('account_tel');
        Session::forget('account_tel_portable');*/

        setcookie("account[account_id]", "", time()-3600);

        setcookie("accountpro[accountpro_id]", "", time()-3600);

        return redirect('/')->with('success', "Déconnecté.");
    }
}
