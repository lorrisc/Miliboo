<?php

namespace App\Http\Controllers;

use App\Models\Compte_client;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class IndexController extends Controller
{

    public function index(Request $request)
    {
   
    }

    public static function loadcategories()
    {
    try {
        $lescategories = DB::table('categories');
        $tcat = array();
        $val = 1;
        foreach ($lescategories as $cat)
        {
            $tcat = array_push($cat->lib_categorie);
            $lessouscategories = DB::table('categories')->where('categorie_id', $val);
            $tscat = array();
            foreach ($lessouscategories as $scat)
            {
                $tscat = array_push($scat->lib_categorie);
            }
            $val += 1;
            dd($tcat);
        }
    } 
    catch (Exception $e) {
        return redirect('/')->withErrors(["Erreur de requête."]);
    }
    }
}