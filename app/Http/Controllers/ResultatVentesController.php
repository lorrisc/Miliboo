<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Crypt;


class ResultatVentesController extends Controller
{
    public function ventesparmois()
    {
        try {
            $tabResVentes = DB::table('commande_mois_view')
            ->select('mois', 'prix', 'année')->get()->toArray();

            return view('directeurVente')->with('tabResVentes', $tabResVentes);
        } catch (Exception $e) {
            return redirect('/')->withErrors(["Pas de résultats."]);
        }
    }

    public function ventesparcategories($mois, $annee)
    {
        try {
         
            $tabResVentesProduits = DB::table('commande_produits_view')
            ->select(DB::raw('sum(prix) as sommeprix,lib_categorie'))
            ->whereMonth('date_commande', $mois)
            ->whereYear('date_commande', $annee)
            ->groupBy('lib_categorie',)
            ->get()->toArray();

            return view('resultatVenteProduits')->with('tabResVentesProduits', $tabResVentesProduits);
        } catch (Exception $e) {
            return redirect('/')->withErrors(["Pas de résultats."]);
        }
    }
}