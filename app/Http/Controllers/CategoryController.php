<?php

namespace App\Http\Controllers;

use App\Http\Controllers\CategoryController as ControllersCategoryController;
use Exception;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Avis;
use Illuminate\Support\Facades\Validator;
use App\Models\Categorie;
use App\Models\PivotUnifier;
use App\Models\PhotoProduit;
use App\Models\Post;
use Illuminate\Support\Arr;

class CategoryController extends Controller
{
    public function viewcategories($id)
    {
        $categoryId = $id;
        try {
            $monTableau = (array)[];
            $catmoyennetab = (array)[];
            $boolcatmoyenne = false;

            $lacategorie = DB::table('categories')
                ->select('lib_categorie', 'photo_path', 'descr_cat', 'id')
                ->where('id', $id)
                ->get()->ToArray();

            $searchtext = $lacategorie[0]->lib_categorie;

            $produits = DB::table('produits')->where('categorie_id', $id)->get()->toArray();
            $catmere = DB::table('categories')->whereNull('categorie_id')->get()->toArray();
            foreach ($catmere as $catm) {
                $catmarray = (array)$catm;
                $catmoyen = DB::table('categories')->where('categorie_id', $catmarray['id'])->select('id')->get()->toArray();
                foreach ($catmoyen as $element) {
                    array_push($catmoyennetab, $element);
                }
            }
            foreach ($catmoyennetab as $catmoytable) {
                $catmoytablearray = (array)$catmoytable;
                if ($id == $catmoytablearray['id']) {
                    $boolcatmoyenne = true;
                }
            }


            if ($boolcatmoyenne == true) {

                $tablecategoriefille = (array)[];
                $cateforiefille = DB::table('categories')->where('categorie_id', $id)->get()->toArray();
                foreach ($cateforiefille as $catfille) {
                    $catarrayfille = (array)$catfille;
                    array_push($tablecategoriefille, $catarrayfille['id']);
                }
                $rankid = 0;
                foreach ($tablecategoriefille as $tablecatfille) {
                    $tablecatarrayfille = (array)$tablecatfille;
                    $produits = DB::table('produits')->where('categorie_id', $tablecatarrayfille)->get()->toArray();
                    foreach ($produits as $items) {
                        $idproduit = $items->id;
                        // $produit['produit'] = DB::table('pivot_unifiers')->where('produit_id', $items->id)->get()->toArray();
                        $produit['produit'] = PivotUnifier::where('produit_id', $idproduit)->get()->toArray();
                        foreach ($produit['produit'] as $item) {
                            $couleur_id = $item['couleur_id'];
                            $produit_img['produit_img'] = DB::table('photo_produits')->where('produit_id', $idproduit)->where('couleur_id', $couleur_id)->get()->toArray();
                            foreach ($produit_img['produit_img'] as $ite) {
                                $item = (array)$item;
                                array_push($item, $ite);
                            }
                            $items = (array)$items;
                            array_push($items, $item);
                        }
                        array_push($monTableau, $items);
                    }
                    $rankid += 1;
                }
                if (isset($monTableau)) {
                    $tablecatarrayfille = (array)$id;
                    $produits = DB::table('produits')->where('categorie_id', $tablecatarrayfille)->get()->toArray();
                    foreach ($produits as $items) {
                        $idproduit = $items->id;
                        // $produit['produit'] = DB::table('pivot_unifiers')->where('produit_id', $items->id)->get()->toArray();
                        $produit['produit'] = PivotUnifier::where('produit_id', $idproduit)->get()->toArray();
                        foreach ($produit['produit'] as $item) {
                            $couleur_id = $item['couleur_id'];
                            $produit_img['produit_img'] = DB::table('photo_produits')->where('produit_id', $idproduit)->where('couleur_id', $couleur_id)->get()->toArray();
                            foreach ($produit_img['produit_img'] as $ite) {
                                $item = (array)$item;
                                array_push($item, $ite);
                            }
                            $items = (array)$items;
                            array_push($items, $item);
                        }
                        array_push($monTableau, $items);
                    }
                    $rankid += 1;
                }
            } else if (count($produits) == 0) {
                return view('result')->with('monTableau', $monTableau)->with('searchtext', $searchtext)->with('lacategorie', $lacategorie)->with('filtervalue', 0);
            } else {
                foreach ($produits as $items) {
                    $idproduit = $items->id;

                    $produit['produit'] = DB::table('pivot_unifiers')->where('produit_id', $items->id)->get()->toArray();
                    foreach ($produit['produit'] as $item) {
                        $couleur_id = $item->couleur_id;
                        $produit_img['produit_img'] = DB::table('photo_produits')->where('produit_id', $idproduit)->where('couleur_id', $couleur_id)->get()->toArray();
                        foreach ($produit_img['produit_img'] as $ite) {
                            $item = (array)$item;
                            array_push($item, $ite);
                        }
                        $items = (array)$items;
                        array_push($items, $item);
                    }
                    $monTableau = (array)$monTableau;
                    array_push($monTableau, $items);
                }
            }

            $filtrecat = false;
            $category = 1;
            return view('result')->with('monTableau', $monTableau)->with('searchtext', $searchtext)->with('lacategorie', $lacategorie)->with('filtrecat', $filtrecat)->with('category',$category);
        } catch (Exception $e) {
            return redirect('/')->withErrors(["Pas de résultats."]);
        }
    }


    public function viewcategoriesfilter(Request $request, $id)
    {

	// return redirect("/categorie/12");


        // TESTS
        $minprix = 0;
        $maxprix = 10000;
        if ($request->prixmin <> null) {$minprix = $request->prixmin; }
        if ($request->prixmax <> null) {$maxprix = $request->prixmax; }


        $colorslib = DB::table('couleurs')->select('lib_couleur')->where('id', $request->couleurs)->get()->toArray();
        $filtervalue = ['id'=>$request->categories, 'prixmin'=>$request->prixmin,'prixmax'=>$request->prixmax,'couleurs'=>$request->couleurs,'lib_couleurs'=>$colorslib,
        'matieres'=>$request->matieres, 'tri'=>$request->triPrix];
        
        if ($request->categories <> null && $request->categories <> 'ToutesCategories')
        {
            $idcat = $request->categories;
        }
        else 
        {
            $idcat = $id;
        }

        // try {
            $catmoyennetab = (array)[];
            $boolcatmoyenne = false;

            //SELECTIONNE LA BONNE CATEGORIE
            $lacategorie = DB::table('categories')
                ->select('lib_categorie', 'photo_path', 'descr_cat', 'id')
                ->where('id', $idcat)
                ->get()->toArray();
            $searchtext = $lacategorie[0]->lib_categorie;
            
            //SELECTIONNE LES PRODUITS CORRESPONDANT A CETTE CATEGORIE
            //SELECTIONNE LES SOUS CATEGORIES DE LA CATEGORIE ACTUELLE, SI IL Y EN A PAS, ALORS LA CATEGORIE ACTUELLE EST DEJA UNE CATEGORIE FILLE, 
            //DANS CE CAS ELLE NE SIUVRA PAS LA MEME FONCTION 

            $catpetitessiexiste = DB::table('categories')->select('id')->where('categorie_id', $idcat)->get();

            if(count($catpetitessiexiste) <> 0)
            {
                //RECUPERE TOUS LES PRODUITS GLOBAUX CORRESPONDANT A TOUTES LES CATEGORIES DE LA CATEOGIRE MERE
                //EX : RECUPERE TOUS LES PRODUITS GLOBAUX CORRESPONDANTS AUX CATEGORIES 13, 14, 15, 16, 17 SI LA CATEGORIE MERE EST 12
                $lesproduits = (array)[];
                foreach ($catpetitessiexiste as $lacatpetitessiexiste)
                {
                    $produits = DB::table('produits')->where('categorie_id', $lacatpetitessiexiste->id)->orderBy('id')->get()->toArray();
                    foreach($produits as $prod)
                    {
                        $prod = (array)$prod;
                        array_push($lesproduits, $prod);
                    }
                }

                // RECUPERE TOUS LES PRODUITS (UNIFIER) CORRESPONDANTS AUX PRODUITS GLOBAUX TROUVES PRECEDEMENT
                $arraylesproduitsunifier = (array)[];
                if ($request->matieres == null)
                {
                    if($request->couleurs == null)
                    {        
                        $lescatfillesqiery = Categorie::select('id')
                        ->where('categorie_id', $idcat)->get()->toArray();

                        $arraylesproduitsunifier = PivotUnifier::select('pivot_unifiers.couleur_id', 'pivot_unifiers.produit_id', 'pivot_unifiers.ensemble_id',
                        'pivot_unifiers.prix', 'pivot_unifiers.promo', 'pivot_unifiers.text_descr')
                        ->join('produits', 'produits.id', 'pivot_unifiers.produit_id')
                        ->join('categories', 'produits.categorie_id', 'categories.id')
                        ->where('prix','>=',$minprix)
                        ->where('prix','<=',$maxprix)
                        ->whereIn('categories.id', $lescatfillesqiery)
                        ->get()->toArray();

                    }


                    else
                    {
                        $lescatfillesqiery = Categorie::select('id')
                        ->where('categorie_id', $id)->get()->toArray();

                        $arraylesproduitsunifier = PivotUnifier::select('pivot_unifiers.couleur_id', 'pivot_unifiers.produit_id', 'pivot_unifiers.ensemble_id',
                        'pivot_unifiers.prix', 'pivot_unifiers.promo', 'pivot_unifiers.text_descr')
                        ->join('produits', 'produits.id', 'pivot_unifiers.produit_id')
                        ->join('categories', 'produits.categorie_id', 'categories.id')
                        ->where('prix','>=',$minprix)
                        ->where('prix','<=',$maxprix)
                        ->where('couleur_id', (int)$request->couleurs)
                        ->whereIn('categories.id', $lescatfillesqiery)
                        ->get()->toArray();
                    }
                }
                else
                {
                    if($request->couleurs == null)
                    {
                        $lescatfillesqiery = Categorie::select('id')
                        ->where('categorie_id', $idcat)->get()->toArray();

                        $arraylesproduitsunifier = PivotUnifier::select('pivot_unifiers.couleur_id', 'pivot_unifiers.produit_id', 'pivot_unifiers.ensemble_id',
                        'pivot_unifiers.prix', 'pivot_unifiers.promo', 'pivot_unifiers.text_descr')
                        ->join('produits', 'produits.id', 'pivot_unifiers.produit_id')
                        ->join('categories', 'produits.categorie_id', 'categories.id')
                        ->where('prix','>=',$minprix)
                        ->where('prix','<=',$maxprix)
                        ->where('matiere', $request->matieres)
                        ->whereIn('categories.id', $lescatfillesqiery)
                        ->get()->toArray();      
                    }

                    else
                    {         
                        $lescatfillesqiery = Categorie::select('id')
                        ->where('categorie_id', $idcat)->get()->toArray();

                        $arraylesproduitsunifier = PivotUnifier::select('pivot_unifiers.couleur_id', 'pivot_unifiers.produit_id', 'pivot_unifiers.ensemble_id',
                        'pivot_unifiers.prix', 'pivot_unifiers.promo', 'pivot_unifiers.text_descr')
                        ->join('produits', 'produits.id', 'pivot_unifiers.produit_id')
                        ->join('categories', 'produits.categorie_id', 'categories.id')
                        ->where('prix','>=',$minprix)
                        ->where('prix','<=',$maxprix)
                        ->where('matiere', $request->matieres)
                        ->where('couleur_id', (int)$request->couleurs)
                        ->whereIn('categories.id', $lescatfillesqiery)
                        ->get()->toArray();
    
                    }
                }


                // CREATION DU TABLEAU COMPRENNANT TOUS LES ELEMENTS DU PRODUIT

                $items = (array)[];

                foreach ($arraylesproduitsunifier as $item) {
                    $couleur_id = $item['couleur_id'];
                    $produit_img['produit_img'] = DB::table('photo_produits')->where('produit_id', $item['produit_id'])->where('couleur_id', $couleur_id)->get()->toArray();
                    foreach ($produit_img['produit_img'] as $ite) {
                        $item = (array)$item;
                        array_push($item, $ite);
                    }
                    array_push($items, $item);
                }

                $tfindid = (array)[];
                foreach($arraylesproduitsunifier as $findid)
                {
                    array_push($tfindid, $findid['produit_id']);
                }

                // ENCAPSULATION DE TABLEAUX
                $monTableau = [];

                foreach($lesproduits as $lesprods)
                {
                    $produiteffectue = 0;
                    foreach ($tfindid as $tfindtheid)
                    {
                        if ($lesprods['id'] == $tfindtheid &&  $produiteffectue == 0)
                        {
                            array_push($monTableau, $lesprods);
                            $produiteffectue = 1;
                        }
                    }                         
                }
               
                $ranktable = 0;
                foreach($monTableau as $monT)
                {
                    foreach ($items as $lesitems)
                    {
                        if ($monT['id'] == $lesitems['produit_id'])
                        {
                            array_push($monTableau[$ranktable], $lesitems);
                        }
                    }
                    $ranktable++; 
                }

                if ($request->triPrix <> "PrixDefault")
                {
                    $tableautrie = (array)[];
                    if($request->triPrix == "PrixCroissant" && (count($monTableau) <> 0))
                    {
                        foreach (range(0, count($monTableau) - 1) as $i)
                        {
                            if ($i == 0)
                            {
                                array_push($tableautrie, $monTableau[$i]);
                            }
                            else
                            {
                                $boolinsertion = false;
                                $booleffectue = false;
                                foreach (range(0, count($tableautrie) - 1) as $j)
                                {
                                    if ((double)$monTableau[$i]['0']['prix'] < (double)$tableautrie[$j]['0']['prix']  && $booleffectue == false)
                                    {
                                        array_splice($tableautrie, $j, 0, array($monTableau[$i]));
                                        $booleffectue = true;
                                        $boolinsertion = true;
                                    }
                                }
                                if ($boolinsertion == false)
                                {
                                    array_push($tableautrie, $monTableau[$i]);
                                }
                            }
                        }
                    }
                    else if (count($monTableau) <> 0)
                    {
                        foreach (range(0, count($monTableau) - 1) as $i)
                        {
                            if ($i == 0)
                            {
                                array_push($tableautrie, $monTableau[$i]);
                            }
                            else
                            {
                                $boolinsertion = false;
                                $booleffectue = false;
                                foreach (range(0, count($tableautrie) - 1) as $j)
                                {
                                    if ((double)$monTableau[$i]['0']['prix'] > (double)$tableautrie[$j]['0']['prix'] && $booleffectue == false)
                                    {

                                        array_splice($tableautrie, $j, 0, array($monTableau[$i]));
                                        $booleffectue = true;
                                        $boolinsertion = true;
                                    }
                                }
                                if ($boolinsertion == false)
                                {
                                    array_push($tableautrie, $monTableau[$i]);
                                }
                            }
                        }                        
                    }
                    $monTableau = $tableautrie;
                }
                $filtrecat = true;
                
                $category = 1;
                return view('result')->with('monTableau', $monTableau)->with('searchtext', $searchtext)->with('lacategorie', $lacategorie)
                ->with('filtervalue', $filtervalue)->with('filtrecat', $filtrecat)->with('category',$category);
            }


            else
            {
                $arraylesproduitsunifier = (array)[];
                if ($request->matieres == null)
                {
                    if($request->couleurs == null)
                    {        
                        $arraylesproduitsunifier = PivotUnifier::select('pivot_unifiers.couleur_id', 'pivot_unifiers.produit_id', 'pivot_unifiers.ensemble_id',
                        'pivot_unifiers.prix', 'pivot_unifiers.promo', 'pivot_unifiers.text_descr')
                        ->join('produits', 'produits.id', 'pivot_unifiers.produit_id')
                        ->join('categories', 'produits.categorie_id', 'categories.id')
                        ->where('prix','>=',$minprix)
                        ->where('prix','<=',$maxprix)
                        ->where('categories.id', $idcat)
                        ->get()->toArray();

                    }


                    else
                    {
                        $arraylesproduitsunifier = PivotUnifier::select('pivot_unifiers.couleur_id', 'pivot_unifiers.produit_id', 'pivot_unifiers.ensemble_id',
                        'pivot_unifiers.prix', 'pivot_unifiers.promo', 'pivot_unifiers.text_descr')
                        ->join('produits', 'produits.id', 'pivot_unifiers.produit_id')
                        ->join('categories', 'produits.categorie_id', 'categories.id')
                        ->where('prix','>=',$minprix)
                        ->where('prix','<=',$maxprix)
                        ->where('couleur_id', (int)$request->couleurs)
                        ->where('categories.id', $idcat)
                        ->get()->toArray();
                    }
                }
                else
                {
                    if($request->couleurs == null)
                    {

                        $arraylesproduitsunifier = PivotUnifier::select('pivot_unifiers.couleur_id', 'pivot_unifiers.produit_id', 'pivot_unifiers.ensemble_id',
                        'pivot_unifiers.prix', 'pivot_unifiers.promo', 'pivot_unifiers.text_descr')
                        ->join('produits', 'produits.id', 'pivot_unifiers.produit_id')
                        ->join('categories', 'produits.categorie_id', 'categories.id')
                        ->where('prix','>=',$minprix)
                        ->where('prix','<=',$maxprix)
                        ->where('matiere', $request->matieres)
                        ->where('categories.id', $idcat)
                        ->get()->toArray();      
                    }

                    else
                    {         

                        $arraylesproduitsunifier = PivotUnifier::select('pivot_unifiers.couleur_id', 'pivot_unifiers.produit_id', 'pivot_unifiers.ensemble_id',
                        'pivot_unifiers.prix', 'pivot_unifiers.promo', 'pivot_unifiers.text_descr')
                        ->join('produits', 'produits.id', 'pivot_unifiers.produit_id')
                        ->join('categories', 'produits.categorie_id', 'categories.id')
                        ->where('prix','>=',$minprix)
                        ->where('prix','<=',$maxprix)
                        ->where('matiere', $request->matieres)
                        ->where('couleur_id', (int)$request->couleurs)
                        ->where('categories.id', $idcat)
                        ->get()->toArray();
    
                    }
                }
                //RECUPERE TOUS LES PRODUITS GLOBAUX CORRESPONDANT A LA CATEGORIE MERE UNIQUE
                $lesproduits = (array)[];
                $produits = DB::table('produits')->where('categorie_id', $idcat)->orderBy('id')->get()->toArray();
                foreach($produits as $prod)
                {
                    $prod = (array)$prod;
                    array_push($lesproduits, $prod);
                }
                

                // CREATION DU TABLEAU COMPRENNANT TOUS LES ELEMENTS DU PRODUIT

                $items = (array)[];

                foreach ($arraylesproduitsunifier as $item) {
                    $couleur_id = $item['couleur_id'];
                    $produit_img['produit_img'] = DB::table('photo_produits')->where('produit_id', $item['produit_id'])->where('couleur_id', $couleur_id)->get()->toArray();
                    foreach ($produit_img['produit_img'] as $ite) {
                        $item = (array)$item;
                        array_push($item, $ite);
                    }
                    array_push($items, $item);
                }

                $tfindid = (array)[];
                foreach($arraylesproduitsunifier as $findid)
                {
                    array_push($tfindid, $findid['produit_id']);
                }

                // ENCAPSULATION DE TABLEAUX
                $monTableau = [];

                foreach($lesproduits as $lesprods)
                {
                    $produiteffectue = 0;
                    foreach ($tfindid as $tfindtheid)
                    {
                        if ($lesprods['id'] == $tfindtheid &&  $produiteffectue == 0)
                        {
                            array_push($monTableau, $lesprods);
                            $produiteffectue = 1;
                        }
                    }                         
                }

                
                $ranktable = 0;
                foreach($monTableau as $monT)
                {
                    foreach ($items as $lesitems)
                    {
                        if ($monT['id'] == $lesitems['produit_id'])
                        {
                            array_push($monTableau[$ranktable], $lesitems);
                        }
                    }
                    $ranktable++; 
                }

                if ($request->triPrix <> "PrixDefault")
                {
                    $tableautrie = (array)[];
                    if($request->triPrix == "PrixCroissant"  && (count($monTableau) <> 0))
                    {
                        foreach (range(0, count($monTableau) - 1) as $i)
                        {
                            if ($i == 0)
                            {
                                array_push($tableautrie, $monTableau[$i]);
                            }
                            else
                            {
                                $boolinsertion = false;
                                $booleffectue = false;
                                foreach (range(0, count($tableautrie) - 1) as $j)
                                {
                                    if ((double)$monTableau[$i]['0']['prix'] < (double)$tableautrie[$j]['0']['prix']  && $booleffectue == false)
                                    {
                                        array_splice($tableautrie, $j, 0, array($monTableau[$i]));
                                        $booleffectue = true;
                                        $boolinsertion = true;
                                    }
                                }
                                if ($boolinsertion == false)
                                {
                                    array_push($tableautrie, $monTableau[$i]);
                                }
                            }
                        }
                    }
                    else if (count($monTableau) <> 0)
                    {
                        foreach (range(0, count($monTableau) - 1) as $i)
                        {
                            if ($i == 0)
                            {
                                array_push($tableautrie, $monTableau[$i]);
                            }
                            else
                            {
                                $boolinsertion = false;
                                $booleffectue = false;
                                foreach (range(0, count($tableautrie) - 1) as $j)
                                {
                                    if ((double)$monTableau[$i]['0']['prix'] > (double)$tableautrie[$j]['0']['prix']  && $booleffectue == false)
                                    {
                                        array_splice($tableautrie, $j, 0, array($monTableau[$i]));
                                        $booleffectue = true;
                                        $boolinsertion = true;
                                    }
                                }
                                if ($boolinsertion == false)
                                {
                                    array_push($tableautrie, $monTableau[$i]);
                                }
                            }
                        }                        
                    }
                    $monTableau = $tableautrie;
                }
                $filtrecat = true;
                $category = 1;
                return view('result')->with('monTableau', $monTableau)->with('searchtext', $searchtext)->with('lacategorie', $lacategorie)
                ->with('filtervalue', $filtervalue)->with('filtrecat', $filtrecat)->with('category',$category);
            }
            // $produits['produits'] = DB::table('produits')->where('lib_produit', 'like', '%' . $data['searchBar'] . '%')->get()->toArray();
            // $monTableau = (array) [];
            // foreach ($produits['produits'] as $items) {
            //     $idproduit = $items->id;                

            //     $produit['produit'] = DB::table('pivot_unifiers')->where('produit_id', $items->id)->get()->toArray();
            //     foreach ($produit['produit'] as $item) {
            //         $couleur_id = $item->couleur_id;
            //         $produit_img['produit_img'] = DB::table('photo_produits')->where('produit_id', $idproduit)->where('couleur_id', $couleur_id)->get()->toArray();
            //         foreach ($produit_img['produit_img'] as $ite) {
            //             $item = (array)$item;
            //             array_push($item,$ite);
            //         }
            //         $items = (array)$items;
            //         array_push($items,$item);
            //     }
            //     $monTableau = (array)$monTableau;
            //     array_push($monTableau,$items);
            // }
        

            // $searchtext = $data['searchBar'];
            // return view('result')->with('monTableau', $monTableau)->with('searchtext', $searchtext)->with('produitid', $idproduit)->with('lacategorie', $lacategorie);
            // // return view('result', [
            // //     'products' => $monTableau
            // // ]);


            //     $tablecategoriefille = $catpetitessiexiste;
            //     foreach ($tablecategoriefille as $tablecatfille) {
            //         $tablecatarrayfille = (array)$tablecatfille;


            //         $produits = DB::table('produits')->where('categorie_id', $tablecatarrayfille)->where('matiere', $request->matieres)->get()->toArray();
            //         foreach ($produits as $items) {
            //             $idproduit = $items->id;
            //             // $produit['produit'] = DB::table('pivot_unifiers')->where('produit_id', $items->id)->get()->toArray();
            //             if ($request->couleurs == null)
            //             {
            //                 $produit['produit'] = PivotUnifier::where('produit_id', $idproduit)
            //                 ->where('prix','>=',$request->prixmin)
            //                 ->where('prix','<=',$request->prixmax)
            //                 ->get()->toArray();
            //             }
            //             else
            //             {
            //                 $produit['produit'] = PivotUnifier::where('produit_id', $idproduit)
            //                 ->where('couleur_id', $request->couleurs)
            //                 ->where('prix','>=',$request->prixmin)
            //                 ->where('prix','<=',$request->prixmax)
            //                 ->get()->toArray();
            //             }
            //             dd($produit['produit']);

            //             $statuspresent = 0;
            //             foreach ($produit['produit'] as $item) {
            //                 $couleur_id = $item['couleur_id'];
            //                 $produit_img['produit_img'] = DB::table('photo_produits')->where('produit_id', $idproduit)->where('couleur_id', $couleur_id)->get()->toArray();
            //                 dd(1);
            //                 foreach ($produit_img['produit_img'] as $ite) {
            //                     $item = (array)$item;
            //                     array_push($item, $ite);
            //                     dd(1);
            //                 }
            //                 $items = (array)$items;
            //                 array_push($items, $item);
            //                 $statuspresent = 1;
            //             }
            //             if ($statuspresent == 1) {
            //                 array_push($monTableau, $items);
            //             }
            //         }
            //         $rankid += 1;
            //     }
            // }


            // if ($boolcatmoyenne == true) {

            //     $tablecategoriefille = (array)[];
            //     $cateforiefille = DB::table('categories')->where('categorie_id', $id)->get()->toArray();
            //     foreach ($cateforiefille as $catfille) {
            //         $catarrayfille = (array)$catfille;
            //         array_push($tablecategoriefille, $catarrayfille['id']);
            //     }

            //     $rankid = 0;
            //     foreach ($tablecategoriefille as $tablecatfille) {
            //         $tablecatarrayfille = (array)$tablecatfille;

            //         $produits = DB::table('produits')->where('categorie_id', $tablecatarrayfille)->where('matiere', $request->matieres)->get()->toArray();
            //         foreach ($produits as $items) {
            //             $idproduit = $items->id;
            //             // $produit['produit'] = DB::table('pivot_unifiers')->where('produit_id', $items->id)->get()->toArray();
            //             if ($request->couleurs == null)
            //             {
            //                 $produit['produit'] = PivotUnifier::where('produit_id', $idproduit)
            //                 ->where('prix','>=',$request->prixmin)
            //                 ->where('prix','<=',$request->prixmax)
            //                 ->get()->toArray();
            //             }
            //             else
            //             {
            //                 $produit['produit'] = PivotUnifier::where('produit_id', $idproduit)
            //                 ->where('couleur_id', $request->couleurs)
            //                 ->where('prix','>=',$request->prixmin)
            //                 ->where('prix','<=',$request->prixmax)
            //                 ->get()->toArray();
            //             }
            //             dd($produit['produit']);

            //             $statuspresent = 0;
            //             foreach ($produit['produit'] as $item) {
            //                 $couleur_id = $item['couleur_id'];
            //                 $produit_img['produit_img'] = DB::table('photo_produits')->where('produit_id', $idproduit)->where('couleur_id', $couleur_id)->get()->toArray();
            //                 dd(1);
            //                 foreach ($produit_img['produit_img'] as $ite) {
            //                     $item = (array)$item;
            //                     array_push($item, $ite);
            //                     dd(1);
            //                 }
            //                 $items = (array)$items;
            //                 array_push($items, $item);
            //                 $statuspresent = 1;
            //             }
            //             if ($statuspresent == 1) {
            //                 array_push($monTableau, $items);
            //             }
            //         }
            //         $rankid += 1;
            //     }
            //     if (isset($monTableau)) {
            //         $tablecatarrayfille = (array)$id;
            //         $produits = DB::table('produits')->where('categorie_id', $tablecatarrayfille)->where('matiere', $request->matieres)->get()->toArray();
            //         foreach ($produits as $items) {
            //             $idproduit = $items->id;
            //             // $produit['produit'] = DB::table('pivot_unifiers')->where('produit_id', $items->id)->get()->toArray();
            //             $produit['produit'] = PivotUnifier::where('produit_id', $idproduit)->where('couleur_id', $request->couleurs)->where('prix','>=',$request->prixmin)->where('prix','<=',$request->prixmax)->get()->toArray();
            //             $statuspresent = 0;
            //             foreach ($produit['produit'] as $item) {
            //                 $couleur_id = $item['couleur_id'];
            //                 $produit_img['produit_img'] = DB::table('photo_produits')->where('produit_id', $idproduit)->where('couleur_id', $couleur_id)->get()->toArray();
            //                 foreach ($produit_img['produit_img'] as $ite) {
            //                     $item = (array)$item;
            //                     array_push($item, $ite);
            //                 }
            //                 $items = (array)$items;
            //                 array_push($items, $item);
            //                 $statuspresent = 1;
            //             }

            //             if ($statuspresent == 1) {
            //                 array_push($monTableau, $items);
            //             }
            //         }
            //         $rankid += 1;
            //     }
            // } else if (count($produits) == 0) {
            //     return view('result')->with('monTableau', $monTableau)->with('searchtext', $searchtext)->with('lacategorie', $lacategorie)->with('filtervalue', $filtervalue);
            // } else {
            //     foreach ($produits as $items) {
            //         $idproduit = $items->id;
            //         $produit['produit'] = DB::table('pivot_unifiers')->where('produit_id', $items->id)->where('couleur_id', $request->couleurs)->where('prix','>=',$request->prixmin)->where('prix','<=',$request->prixmax)->get()->toArray();
            //         $statuspresent = 0;
            //         foreach ($produit['produit'] as $item) {
            //             $couleur_id = $item->couleur_id;
            //             $produit_img['produit_img'] = DB::table('photo_produits')->where('produit_id', $idproduit)->where('couleur_id', $couleur_id)->get()->toArray();
            //             foreach ($produit_img['produit_img'] as $ite) {
            //                 $item = (array)$item;
            //                 array_push($item, $ite);
            //             }
            //             $items = (array)$items;
            //             array_push($items, $item);
            //             $statuspresent = 1;
            //         }
            //         $monTableau = (array)$monTableau;
            //         if ($statuspresent == 1) {
            //             array_push($monTableau, $items);
            //         }
            //     }
            // }
            // return view('result')->with('monTableau', $monTableau)->with('searchtext', $searchtext)->with('lacategorie', $lacategorie)->with('filtervalue', $filtervalue);
        // } catch (Exception $e) {
        //     return redirect('/')->withErrors(["Pas de résultats."]);
        // }
    }
}
