<?php

namespace App\Http\Controllers;

use App\Models\PivotProduitAime;
use App\Models\PivotUnifier;
use App\Models\Produit;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;



class ResultController extends Controller
{
    public function index(Request $request)
    {
        $lacategorie = array(
            array('lib_categorie' => 'toutes categories',
            'photo_path' => null,
            'descr_cat' => null,
            'id' => null)
        );

        $lacategorie[0] = (object)$lacategorie[0];

        $data = $request->input();
        try {
            $produits['produits'] = DB::table('produits')->where('lib_produit', 'like', '%' . $data['searchBar'] . '%')->get()->toArray();
            $monTableau = (array) [];
            foreach ($produits['produits'] as $items) {
                $idproduit = $items->id;                

                $produit['produit'] = DB::table('pivot_unifiers')->where('produit_id', $items->id)->get()->toArray();
                foreach ($produit['produit'] as $item) {
                    $couleur_id = $item->couleur_id;
                    $produit_img['produit_img'] = DB::table('photo_produits')->where('produit_id', $idproduit)->where('couleur_id', $couleur_id)->get()->toArray();
                    foreach ($produit_img['produit_img'] as $ite) {
                        $item = (array)$item;
                        array_push($item,$ite);
                    }
                    $items = (array)$items;
                    array_push($items,$item);
                }
                $monTableau = (array)$monTableau;
                array_push($monTableau,$items);
            }
        

            $searchtext = $data['searchBar'];
            return view('result')->with('monTableau', $monTableau)->with('searchtext', $searchtext)->with('produitid', $idproduit)->with('lacategorie', $lacategorie);
            // return view('result', [
            //     'products' => $monTableau
            // ]);
        } catch (Exception $e) {
            return redirect('/')->withErrors(["Pas de résultats."]);
        }
    }


    public function promotion($id = null)
    {
        try {
            $unifiers['unifiers'] = PivotUnifier::all()
            ->toArray();
            //dd($produits['produits']);

            $monTableau = (array) [];
            foreach ($unifiers['unifiers'] as $items) {
                if($items['promo'] != "1"){
                    $idproduit = $items['produit_id'];
                    $produit['produit'] = DB::table('produits')->where('id', $idproduit)->get()->toArray();
                    foreach ($produit['produit'] as $item) {
                        //dd($item->promo != 1);
                            $couleur_id = $items['couleur_id'];
                            $produit_img = DB::table('photo_produits')->where('produit_id', $idproduit)->where('couleur_id', $couleur_id)->get()->toArray();
                            //dd($produit_img);
                            foreach ($produit_img as $ite) {
                                $item = (array)$item;
                                array_push($item,$ite);
                            }
                            $items = (array)$items;
                            array_push($items,$item);
                    }
                    $monTableau = (array)$monTableau;
                    array_push($monTableau,$items);
                }
            }   

            return view('promotion')->with('monTableau', $monTableau)->with('produitid', $idproduit);
        } catch (Exception $e) {
            return redirect('/')->withErrors(["Pas de résultats."]);
        }
    }
    

    public function madeinfrance()
    {


        try { 

            $produits['produits'] = DB::table('produits')
            ->where('produits.mention_id', '=', 1)
            ->get()->toArray();

            

            $monTableau = (array) [];
            foreach ($produits['produits'] as $items) {                

                $idproduit = $items->id;
                
                $produit['produit'] = DB::table('pivot_unifiers')->where('produit_id', $items->id)->get()->toArray();  
                
                foreach ($produit['produit'] as $item) {
                    $couleur_id = $item->couleur_id;
                    $produit_img['produit_img'] = DB::table('photo_produits')->where('produit_id', $idproduit)->where('couleur_id', $couleur_id)->get()->toArray();

                    foreach ($produit_img['produit_img'] as $ite) {
                        $item = (array)$item;
                        array_push($item,$ite);
                    }

                    $items = (array)$items;
                    array_push($items,$item);
                }
                $monTableau = (array)$monTableau;
                array_push($monTableau,$items);

            }
           

          


            // $produits = DB::table('produits')
            // ->where('produits.mention_id', '=', 1)->get()->toArray();
            // // dd($produits);
            // $produits = (array)$produits;
        
            // $monTableau = (array) [];

            // foreach (range(0, count($produits) - 1) as $i) {
            //     $produits[$i] = (array)$produits[$i];
            //     $unifier = PivotUnifier::where('produit_id', $produits[$i]['id'])->get()->toArray();

            //     foreach ($unifier as $item) {
            //         $couleur_id = $item['couleur_id'];
            //         $produit_img['produit_img'] = DB::table('photo_produits')->where('produit_id', $item['produit_id'])->where('couleur_id', $couleur_id)->get()->toArray();
            //         $produit_img['produit_img'] = (array) $produit_img['produit_img'];
            //         foreach ($produit_img['produit_img'] as $ite) {
            //             $item = (array)$item;
            //             array_push($item, $ite);
            //         }
            //     }
            //     $monTableau = (array)$monTableau;
            //     array_push($produits[$i], $item);           
            // }
            // // dd($produits);
            // $monTableau = $produits;
            // // dd($monTableau);
        

            return view('madeinfrance')->with('monTableau', $monTableau)->with('produitid', $idproduit);
        } catch (Exception $e) {
            return redirect('/')->withErrors(["Pas de résultats."]);
        }
    }


    public function nouveautes()
    {
        try {
            //$produits = $request->input();
            $produits['produits'] = DB::table('produits')
            ->whereDate('produits.created_at', '>', Carbon::today()->subMonths(2))
            ->get()->toArray();
            //$mama = Carbon::today()->subMonths();
            //dd($mama);

            $monTableau = (array) [];
            //dd($produits);
            foreach ($produits['produits'] as $items) {                

                $idproduit = $items->id;
                
                $produit['produit'] = DB::table('pivot_unifiers')->where('produit_id', $items->id)->get()->toArray();                
                foreach ($produit['produit'] as $item) {
                    $couleur_id = $item->couleur_id;
                    $produit_img['produit_img'] = DB::table('photo_produits')->where('produit_id', $idproduit)->where('couleur_id', $couleur_id)->get()->toArray();
                    foreach ($produit_img['produit_img'] as $ite) {
                        $item = (array)$item;
                        array_push($item,$ite);
                    }
                    $items = (array)$items;
                    array_push($items,$item);
                }
                $monTableau = (array)$monTableau;
                    array_push($monTableau,$items);
            }
            //dd($monTableau);
            // return view('promotion')->with('monTableau',$monTableau);
            return view('nouveautes')->with('monTableau',$monTableau)->with('produitid', $idproduit);
            // return view('result', [
            //     'products' => $monTableau
            // ]);
        } catch (Exception $e) {
            return redirect('/')->withErrors(["Pas de résultats."]);
        }
    }

    public function filtrer(Request $request)
    {
        $data = $request->input();

        try {
            $produits['produits'] = DB::table('produits')->where('lib_produit', 'like', '%' . $data['filtrerpar'] . '%')->get()->toArray();
            $monTableau = (array) [];
            foreach ($produits['produits'] as $items) {
                $idproduit = $items->id;

                $produit['produit'] = DB::table('pivot_unifiers')->where('produit_id', $items->id)->get()->toArray();
                foreach ($produit['produit'] as $item) {
                    $couleur_id = $item->couleur_id;
                    $produit_img['produit_img'] = DB::table('photo_produits')->where('produit_id', $idproduit)->where('couleur_id', $couleur_id)->get()->toArray();
                    foreach ($produit_img['produit_img'] as $ite) {
                        $item = (array)$item;
                        array_push($item,$ite);
                    }
                    $items = (array)$items;
                    array_push($items,$item);
                }
                $monTableau = (array)$monTableau;
                array_push($monTableau,$items);
            }
            // dd($monTableau);
            $searchtext = $data['filtrerpar'];
            return view('result')->with('monTableau',$monTableau);
            // return view('result', [
            //     'products' => $monTableau
            // ]);
        } catch (Exception $e) {
            return redirect('/')->withErrors(["Pas de résultats."]);
        }
    }


    
    public function likes()
    {
        try {

            $mesproduitsaimes = PivotProduitAime::where('compte_client_id', $_COOKIE['account']['account_id'])
            ->get()->toArray();

            $produitslikes = [];

            foreach ($mesproduitsaimes as $mpl)
            {
                $leproduit = Produit::where('id', $mpl['produit_id'])
                ->get()->toArray();
                $leproduit = $leproduit[0];
                array_push($produitslikes, $leproduit);
            }

            $monTableau = (array) [];
            foreach ($produitslikes as $items) {
                $idproduit = $items['id'];                

                $produit['produit'] = PivotUnifier::where('produit_id', $items['id'])->get()->toArray();
                foreach ($produit['produit'] as $item) {
                    $couleur_id = $item['couleur_id'];
                    $produit_img['produit_img'] = DB::table('photo_produits')->where('produit_id', $idproduit)->where('couleur_id', $couleur_id)->get()->toArray();
                    foreach ($produit_img['produit_img'] as $ite) {
                        $item = (array)$item;
                        array_push($item,$ite);
                    }
                    $items = (array)$items;
                    array_push($items,$item);
                }
                $monTableau = (array)$monTableau;
                array_push($monTableau,$items);
            }

            $searchtext = 'Produits aimés : ';
            return view('result')->with('monTableau', $monTableau)->with('searchtext', $searchtext)->with('produitid', $idproduit);

        } catch (Exception $e) {
            return redirect('/')->withErrors(["Pas de résultats."]);
        }
    }





    //fonction exemple de création de produit
    // public function create(Request $request){
    //     $request->validate([
    //         "name" => ["required", "string"],
    //         "price" => ["required", "numeric", "min:1"]

    //     ]);

    //     $brand = Produit::find($request->brand);
    //     $brand->beers()->create([
    //         "name" => $request->name,
    //         "price" => $request->price
    //     ]);

    //     return redirect("/");
    // }

    // public function delete($id){
    //     $produit = Produit::FindOrFail($id);
    //     $produit->bars()->detach();
    //     $produit->delete();

    //     return redirect()->back();
    // }

    // public function showUpdate($id){
    //     $produit = Produit::findOrFail($id);
    //     $brands = Brand::all();

    //     return view("produit_update", [
    //         "beer" => $beer,
    //         "brands" => $brands
    //     ]);
    // }

    // CEST CA QUI FAIT BUGER LA RECHERCHCE POUR LE MOMENT (pour le mec dessus)
    // public function delete($id){
    //     $produit = Produit::FindOrFail()


    //     return redirect()->back();
    // });
}
