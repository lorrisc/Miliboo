<?php

namespace App\Http\Controllers;

use App\Models\AdresseLivraison;
use App\Models\Civilite;
use App\Models\CodePostal;
use App\Models\Commande;
use App\Models\CompteClient;
use App\Models\PhotoProduit;
use App\Models\Produit;
use App\Models\PivotLignePanier;
use App\Models\PivotUnifier;
use App\Models\Ville;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class MarketController extends Controller
{
    public function index()
    {
        if ((count(Cart::content())) > 0) {
            if(isset($_COOKIE['account']['account_id']))
            {
                $user_id = $_COOKIE['account']['account_id'];
            }
            if (isset($user_id)) {

                $fidelityPoint = CompteClient::where('compte_clients.id', '=', $user_id)
                    ->get(['point_fidelite'])
                    ->first()
                    ->toArray();
                $fidelityPointUse = Commande::where('compte_client_id', '=', $user_id)
                    ->get(['fidelity_use'])
                    ->first()
                    ->toArray();

                    $account_id = $_COOKIE['account']['account_id'];         

                    // retrieve deliveries
                    $deliveries = [];
                    if ($deliveriesGet = AdresseLivraison::where('compte_client_id', '=', $account_id)->first() == null) {
                        return view('accountinfoperso')->with('deliveries', $deliveries);
                    } else {
                        $deliveriesGet = AdresseLivraison::where('compte_client_id', '=', $account_id)->get()->toArray();
                        // dd($deliveriesGet);
                        foreach ($deliveriesGet as $delivery) {
                            //dd($delivery['id']);
                            $city = Ville::where('id', $delivery['ville_id'])->first();
                            $lib_ville = $city->lib_ville;
            
                            $postal_zip = CodePostal::where('id', $delivery['code_postal_id'])->first();
                            $lib_postal_zip = $postal_zip->lib_cp;
            
                            $civilite_id = Civilite::where('id', $delivery['civilite_id'])->first();
                            $civilite_lib = $civilite_id->lib_civilite;
            
                            $newdelivery = array(
                                'id' => $delivery['id'],
                                'nom_adresse' => $delivery['nom_adresse'],
                                'nom' => $delivery['nom'],
                                'prenom' => $delivery['prenom'],
                                'civilite_lib' => $civilite_lib,
            
                                'tel' => $delivery['tel'],
                                'tel_portable' => $delivery['tel_portable'],
            
                                'adresse_livraison' => $delivery['adresse_livraison'],
                                'ville_lib' => $lib_ville,
                                'code_postal_lib' => $lib_postal_zip,
                                'pay_id' => 1,
                            );
            
                            array_push($deliveries, $newdelivery);
                        }
                    }

                return view('market')->with('fidelityPoint', $fidelityPoint['point_fidelite'])->with('fidelityPointUse', $fidelityPointUse['fidelity_use'])->with('deliveries', $deliveries);
            } else {
                return view('market');
            }
        } else {
            return view('marketempty');
        }
    }

    public function commande(Request $request)
    {
        $crytpedcodecarte = Crypt::encrypt($request->codecarte);
        $cryptedcryptogramme = Crypt::encrypt($request->cryptogramme);
        $cryptogrammedateexp = Crypt::encrypt($request->dateexpriation);

        CompteClient::where('id', $_COOKIE['account']['account_id'])->update(['num_carte' => $crytpedcodecarte]);
        dd(1);

        $deliveriesGet = AdresseLivraison::where('id', '=', $_COOKIE['idadress'])->first()->toArray();

        $city = Ville::where('id', $deliveriesGet['ville_id'])->first();
        $lib_ville = $city->lib_ville;

        $postal_zip = CodePostal::where('id', $deliveriesGet['code_postal_id'])->first();
        $lib_postal_zip = $postal_zip->lib_cp;

        $civilite_id = Civilite::where('id', $deliveriesGet['civilite_id'])->first();
        $civilite_lib = $civilite_id->lib_civilite;

        $newdelivery = array(
            'id' => $deliveriesGet['id'],
            'nom_adresse' => $deliveriesGet['nom_adresse'],
            'nom' => $deliveriesGet['nom'],
            'prenom' => $deliveriesGet['prenom'],
            'civilite_lib' => $civilite_lib,

            'tel' => $deliveriesGet['tel'],
            'tel_portable' => $deliveriesGet['tel_portable'],

            'adresse_livraison' => $deliveriesGet['adresse_livraison'],
            'ville_lib' => $lib_ville,
            'code_postal_lib' => $lib_postal_zip,
            'pay_id' => 1,
        );
        $newdelivery = array($newdelivery);


        // BDD UPDATES
        Cart::destroy();

        $lacommandeencours = Commande::where('statut_commande', 'Panier')->where('compte_client_id', $_COOKIE['account']['account_id'])
        ->first()->toArray();

        Commande::where('id', $lacommandeencours['id'])->update(['statut_commande' => 'En cours de traitement']);

        $lacommandeencoursupdate = Commande::where('statut_commande', 'En cours de traitement')
        ->where('commandes.compte_client_id', $_COOKIE['account']['account_id'])
        ->orderBy('date_commande', 'desc')
        ->first()->toArray();

        $leslignes = PivotLignePanier::where('commande_id', $lacommandeencoursupdate['id'])->get()->toArray();

        $rankid = 0;

        foreach($leslignes as $laligne)
        {

            $photo = PhotoProduit::select('url_photo_produit')->where('produit_id', $laligne['produit_id'])->first()->toArray();
            array_push($leslignes[$rankid], $photo['url_photo_produit']);

            $nameproduct = Produit::select('lib_produit')->where('id', $laligne['produit_id'])->first()->toArray();
            array_push($leslignes[$rankid], $nameproduct['lib_produit']);

            $prixpromo = PivotUnifier::select('prix', 'promo')->where('produit_id', $laligne['produit_id'])
            ->where('couleur_id', $laligne['couleur_id'])
            ->first()->toArray();
            
            array_push($leslignes[$rankid], $prixpromo['prix']);
            array_push($leslignes[$rankid], $prixpromo['promo']);
            array_push($leslignes[$rankid], $prixpromo['prix'] * $prixpromo['promo']);

            $rankid++;
        }


        array_push($lacommandeencoursupdate, $leslignes);

    return view('commande')->with('deliveries', $newdelivery)->with('commandupdate', $lacommandeencoursupdate);
    }


    public function commandespassees()
    {
        $deliveriesGet = AdresseLivraison::where('id', '=', $_COOKIE['idadress'])->first()->toArray();

        $city = Ville::where('id', $deliveriesGet['ville_id'])->first();
        $lib_ville = $city->lib_ville;

        $postal_zip = CodePostal::where('id', $deliveriesGet['code_postal_id'])->first();
        $lib_postal_zip = $postal_zip->lib_cp;

        $civilite_id = Civilite::where('id', $deliveriesGet['civilite_id'])->first();
        $civilite_lib = $civilite_id->lib_civilite;

        $newdelivery = array(
            'id' => $deliveriesGet['id'],
            'nom_adresse' => $deliveriesGet['nom_adresse'],
            'nom' => $deliveriesGet['nom'],
            'prenom' => $deliveriesGet['prenom'],
            'civilite_lib' => $civilite_lib,

            'tel' => $deliveriesGet['tel'],
            'tel_portable' => $deliveriesGet['tel_portable'],

            'adresse_livraison' => $deliveriesGet['adresse_livraison'],
            'ville_lib' => $lib_ville,
            'code_postal_lib' => $lib_postal_zip,
            'pay_id' => 1,
        );
        $newdelivery = array($newdelivery);


        // BDD UPDATES
        $lescommandespassees = Commande::where('statut_commande', '!=', 'Panier')
        ->where('commandes.compte_client_id', $_COOKIE['account']['account_id'])
        ->orderBy('date_commande', 'desc')
        ->get()->toArray();

        $rankid = 0;

        foreach ($lescommandespassees as $lacommande)
        {
            $leslignes = PivotLignePanier::where('commande_id', $lacommande['id'])->get()->toArray();

            $rankid2 = 0;
    
            foreach($leslignes as $laligne)
            {   
                $photo = PhotoProduit::select('url_photo_produit')->where('produit_id', $laligne['produit_id'])->first()->toArray();
                array_push($leslignes[$rankid2], $photo['url_photo_produit']);
    
                $nameproduct = Produit::select('lib_produit')->where('id', $laligne['produit_id'])->first()->toArray();
                array_push($leslignes[$rankid2], $nameproduct['lib_produit']);
    
                $prixpromo = PivotUnifier::select('prix', 'promo')->where('produit_id', $laligne['produit_id'])
                ->where('couleur_id', $laligne['couleur_id'])
                ->first()->toArray();
                
                array_push($leslignes[$rankid2], $prixpromo['prix']);
                array_push($leslignes[$rankid2], $prixpromo['promo']);
                array_push($leslignes[$rankid2], $prixpromo['prix'] * $prixpromo['promo']);
    
                $rankid2++;
            }

            array_push($lescommandespassees[$rankid], $leslignes);
            $rankid++;
        }

        return view('commandespassees')->with('commandupdate', $lescommandespassees)->with('deliveries', $newdelivery);
    }


    public function fidelityPointAdd($total, $fidelityPoint)
    {
        $user_id = $_COOKIE['account']['account_id'];
        if ($fidelityPoint < $total) {
            CompteClient::where('id', $user_id)->update(['point_fidelite' => 0]);
            Commande::where('compte_client_id', $user_id)->where('statut_commande', 'Panier')->update(['fidelity_use' => $fidelityPoint]);
            return redirect('/monpanier');
        } else {
            $pfide = CompteClient::where('id', $user_id)->get(['point_fidelite'])->toarray();
            CompteClient::where('id', $user_id)->update(['point_fidelite' => $pfide[0]['point_fidelite'] - $total]);
            Commande::where('compte_client_id', $user_id)->where('statut_commande', 'Panier')->update(['fidelity_use' => $total]);
            return redirect('/monpanier');
        }
    }
}

