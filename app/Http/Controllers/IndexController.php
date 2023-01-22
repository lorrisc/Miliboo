<?php

namespace App\Http\Controllers;

use App\Models\AdresseLivraison;
use Illuminate\Http\Request;
use App\Models\Commande;
use App\Models\PhotoProduit;
use App\Models\PivotLignePanier;
use App\Models\Produit;
use Gloudemans\Shoppingcart\Facades\Cart;
use Exception;


class IndexController extends Controller
{
    public function index(){
        if(isset($_COOKIE['account']['account_id']) && (count(Cart::content()) == null))
        {
            try {
                $account_id = $_COOKIE['account']['account_id'];
                $command = Commande::where('compte_client_id', '=', $account_id)->where('statut_commande', '=', 'Panier')->first();
                $panier =  Cart::content();
                if (isset($account_id)) {
                    $cartlines = PivotLignePanier::where('commande_id', '=', $command->id)->get()->toArray();
                    foreach ($cartlines as $key => $cartline) {
                        $cartlineidentifier = $cartline['produit_id'] . $cartline['couleur_id'];

                        $presentincart = 0;
                        foreach ($panier as $key => $productt) {
                            if ($productt->options['productid'] == $cartline['produit_id'] && $productt->options['colorid'] == $cartline['couleur_id']) {
                                $presentincart = 1;
                            }
                        }
                        if ($presentincart == 0) {
                            //add db product to cart
                            //get product data
                            $productdb = Produit::join('pivot_unifiers', 'pivot_unifiers.produit_id', 'produits.id')
                                ->where('id', '=', $cartline['produit_id'])
                                ->where('couleur_id', '=', $cartline['couleur_id'])
                                ->get(['lib_produit', 'prix', 'promo'])
                                ->first();

                            $pathimg  = PhotoProduit::where('produit_id', '=', $cartline['produit_id'])->where('couleur_id', '=',  $cartline['couleur_id'])->get()->first();
                            //insert in basket
                            Cart::add([
                                'id' => $cartlineidentifier,
                                'name' => $productdb['lib_produit'],
                                'qty' => $cartline['qte'],
                                'price' => $productdb['prix'] * $productdb['promo'],
                                'weight' => 0,
                                'options' => [
                                    'productid' => $cartline['produit_id'],
                                    'colorid' => $cartline['couleur_id'],
                                    'pathimg' => $pathimg['url_photo_produit'],
                                    'promo' => $productdb['promo'],
                                    'initialprice' => $productdb['prix']
                                ]
                            ]);
                        }
                    }
                }
            } catch (Exception $e) {
                $a=1;
            }
        }

        if (!isset($_COOKIE['idadress']) && isset($_COOKIE['account']['account_id']))
        {
            $baseadress = AdresseLivraison::select('id')->where('compte_client_id', $_COOKIE['account']['account_id'])->first()->toArray();
            setcookie('idadress', $baseadress['id'], time()+60*60*24*30);
        }

        return view('index');
    }
}
