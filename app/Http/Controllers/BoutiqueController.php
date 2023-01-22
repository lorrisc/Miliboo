<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BoutiqueController extends Controller
{
    public function index()
    {
        $shops = DB::table('boutiques')
            ->select('titre', 'tel', 'mail', 'indication', 'adresse', 'lib_cp', 'lib_ville')
            ->join('pivot_acces_boutiques', 'boutiques.id', '=', 'pivot_acces_boutiques.boutique_id')
            ->join('acces_boutique', 'pivot_acces_boutiques.acces_boutique_id', '=', 'acces_boutique.id')
            ->join('villes', 'boutiques.ville_id', '=', 'villes.id')
            ->join('code_postals', 'boutiques.code_postal_id', '=', 'code_postals.id')
            ->get()->toArray();

        return view('seeshop')->with('shops', $shops);
    }
}
