<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use Illuminate\Http\Request;

use App\Models\PhotoProduit;
use App\Models\PivotLignePanier;
use App\Models\PivotUnifier;
use App\Models\Produit;
use Illuminate\Support\Carbon;
use Exception;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;

class ShoppingCartController extends Controller
{
    public function addProduct($productid, $colorid, Request $request)
    {
        $generateid = (array) [ $productid,  $colorid ];
        //get product data
        $product = Produit::join('pivot_unifiers', 'pivot_unifiers.produit_id', 'produits.id')
            ->where('id', '=', $productid)
            ->where('couleur_id', '=', $colorid)
            ->get(['lib_produit', 'prix', 'promo'])
            ->first();

        $pathimg  = PhotoProduit::where('produit_id', '=', $productid)->where('couleur_id', '=', $colorid)->get()->first();
        //insert in basket

        Cart::add([
            'id' => $generateid[0].'_'.$generateid[1],
            'name' => $product['lib_produit'],
            'qty' => $request->nbArticles,
            'price' => $product['prix'] * $product['promo'],
            'weight' => 0,
            'options' => [
                'productid' => $productid,
                'colorid' => $colorid,
                'pathimg' => $pathimg['url_photo_produit'],
                'promo' => $product['promo'],
                'initialprice' => $product['prix']
            ]
        ]);

        if (isset($_COOKIE['account']['account_id']))
        {
            $account_id = $_COOKIE['account']['account_id'];
        }

        //user is connected
        if (isset($account_id)) {

            $command = Commande::where('compte_client_id', '=', $account_id)->where('statut_commande', '=', 'Panier')->first();
            //dont have any command
            if (!isset($command)) {
                //create command
                Commande::create(
                    array(
                           'compte_client_id'   =>  $_COOKIE['account']['account_id'],
                           'paiement_id'   =>  1,
                           'livreur_id'   =>  random_int(1, 6),
                           'livraison_express'   =>  False,
                           'statut_commande'   =>  'Panier',
                           'date_commande'   =>  Carbon::now()->format('Y-m-d, H:i:s'),
                           'transport_id'   =>  random_int(1, 3),
                           'id_adresse'   =>  $_COOKIE['idadress'],
                           'emporte'   =>  'False'
                    )
               );

                $usercommand = Commande::where('compte_client_id', '=', $account_id)->where('statut_commande', '=', 'Panier')->first();
                //create ligne panier
                DB::insert('insert into pivot_ligne_paniers (produit_id, couleur_id,commande_id,qte) values (?, ?,?,?)', [$productid, $colorid, $usercommand->id, $request->nbArticles]);
            } elseif (isset($command)) {
                //user have a command with "panier" statut
                $cartlines = PivotLignePanier::where('commande_id', '=', $command->id)->get()->toArray();
                foreach ($cartlines as $key => $cartline) {
                    $cartlineidentifier = $cartline['produit_id'].'_'.$cartline['couleur_id'];
                    if ($generateid == $cartlineidentifier) {
                        $idem = 1;
                    } else {
                        $panier =  Cart::content();
                        $alreadyin = 0;
                        foreach ($panier as $key => $productt) {
                            if ($productt->id == $cartlineidentifier && $alreadyin!=1) {
                                $alreadyin = 1;
                            }
                        }
                        //produit non présent dans cart
                        if ($alreadyin == 0) {
                            // add product in cart

                            //get product data
                            $productdb = Produit::join('pivot_unifiers', 'pivot_unifiers.produit_id', 'produits.id')
                                ->where('id', '=', $cartline['produit_id'])
                                ->where('couleur_id', '=', $cartline['couleur_id'])
                                ->get(['lib_produit', 'prix', 'promo'])
                                ->first();

                            $pathimg  = PhotoProduit::where('produit_id', '=', $cartline['produit_id'])->where('couleur_id', '=',  $cartline['couleur_id'])->get()->first();
                            //insert in basket
                            Cart::add([
                                'id' => $generateid[0].'_'.$generateid[1],
                                'name' => $productdb['lib_produit'],
                                'qty' => $cartline['qte'],
                                'price' => $productdb['prix'] * $productdb['promo'],
                                'weight' => 0,
                                'options' => [
                                    'productid' => $productid,
                                    'colorid' => $colorid,
                                    'pathimg' => $pathimg['url_photo_produit'],
                                    'promo' => $productdb['promo'],
                                    'initialprice' => $productdb['prix']
                                ]
                            ]);
                        }

                    }
                }

                // Pour chaque cart si non present dans bd add
                $panier =  Cart::content();
                $cartlines = PivotLignePanier::where('commande_id', '=', $command->id)->get()->toArray();
                foreach ($panier as $key => $productt) {
                    $presentindb = 0;


                    foreach ($cartlines as $key => $cartline) {
                        $dbidentifier = $cartline['produit_id'].'_'.$cartline['couleur_id'];
                        if ($productt->id == $dbidentifier) {
                            $presentindb = 1;
                            PivotLignePanier::where('produit_id', $productid)->where('couleur_id', $colorid)
                            ->update( [ 'qte' => $cartline['qte'] + $request->nbArticles ] );
                        }
                    }
                    if ($presentindb == 0) {
                        DB::insert('insert into pivot_ligne_paniers (produit_id, couleur_id,commande_id,qte) values (?, ?,?,?)', [$productt->options['productid'], $productt->options['colorid'], $command->id, $productt->qty]);
                    }
                }
            }
        }
        return redirect('/produit/' . $productid . '/' . $product['lib_produit'] . '/' . $colorid);
    }
    public function removeProduct($productmarketid)
    {
        $panier =  Cart::content();
        $productiddelete = 0;
        $coloriddelete = 0;
        foreach ($panier as $key => $value) {
            if ($value->id == $productmarketid) {
                $productiddelete = $value->options['productid'];
                $coloriddelete = $value->options['colorid'];

                $rowId = $value->rowId;
                Cart::remove($rowId);
            }
        }

        $account_id = $_COOKIE['account']['account_id'];
        //user is connect
        if (isset($account_id)) {
            $usercommand = Commande::where('compte_client_id', '=', $account_id)->where('statut_commande', '=', 'Panier')->first();
            $lignep = PivotLignePanier::where('commande_id', $usercommand->id)->Where('produit_id', $productiddelete)->Where('couleur_id', $coloriddelete)->delete();
        }

        return redirect('/monpanier');
    }
    public function changeQuantityProduct($productmarketid, Request $request)
    {
        $panier =  Cart::content();
        $productiddelete = 0;
        $coloriddelete = 0;
        foreach ($panier as $key => $value) {
            if ($value->id == $productmarketid) {
                $productiddelete = $value->options['productid'];
                $coloriddelete = $value->options['colorid'];

                $rowId = $value->rowId;
                Cart::update($rowId, $request->qty);
            }
        }

        $account_id = $_COOKIE['account']['account_id'];
        //user is connect
        if (isset($account_id)) {
            $usercommand = Commande::where('compte_client_id', '=', $account_id)->where('statut_commande', '=', 'Panier')->first();
            $lignep = PivotLignePanier::where('commande_id', $usercommand->id)->Where('produit_id', $productiddelete)->Where('couleur_id', $coloriddelete)->update(['qte'=>$request->qty]);
        }

        return redirect('/monpanier');
    }
    public function removeAllProducts()
    {
        Cart::destroy();

        return redirect('/');
    }
}
