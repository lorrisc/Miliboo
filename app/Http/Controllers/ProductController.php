<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Avis;
use App\Models\PhotoProduit;
use App\Models\PivotDernieresConsult;
use App\Models\PivotLignePanier;
use App\Models\PivotProduitAime;
use App\Models\PivotUnifier;
use App\Models\Produit;
use App\Models\ReponseSociete;
use PhpParser\Node\Expr\AssignOp\Concat;

class ProductController extends Controller
{
    public function produit($id, $libProduit, $idCouleur)
    {
        // SI AUCUN COMPTE CONNECTE, ID GENERE PARMI ID INEXISTANTS, 

        $arrCouleursDispoPourLId = PivotUnifier::where('produit_id', '=', $id)->where('couleur_id', '=', $idCouleur)->get()->toArray();

        //si on entre une URL avec une couleur bizarre
        if (count($arrCouleursDispoPourLId) == 0) {
            return response(redirect(url('/404_not_found')), 404);
        }

        $produit = PivotUnifier::join('produits', 'produits.id', 'pivot_unifiers.produit_id')
            ->join('categories', 'categories.id', 'produits.categorie_id')
            ->Join('photo_produits', 'photo_produits.produit_id', 'produits.id')
            ->where('pivot_unifiers.produit_id', '=', $id)
            ->where('photo_produits.couleur_id', '=', $idCouleur)
            ->get()->first();

        //dd($produit);

        (array)$listToutesLesCouleurs = PivotUnifier::join('produits', 'produits.id', 'pivot_unifiers.produit_id')
            ->where('pivot_unifiers.produit_id', '=', $id)
            ->get()->toArray();

        $libCategorie = $produit['lib_categorie'];
        

        (array)$unifier = PivotUnifier::where('produit_id', '=', $id)->where('couleur_id', '=', $idCouleur)->get();

        $pointsFidelite = 0;
        $fig = (int) str_pad('1', 1, '0');
        if ($produit['promo'] == 1) {
            $pointsFidelite = (floor($produit['prix'] * 0.1 * $fig) / $fig);
        } else {
            $pointsFidelite = (floor($produit['prix'] * $produit['promo'] * 0.1 * $fig) / $fig);
        }


        //Photos
        (array)$lesPhotosUnifier = PhotoProduit::where('produit_id', '=', $id)->where('couleur_id', '=', $idCouleur)->get();

        //$lesPhotosUnifier = array_push($lesPhotosUnifier, )

        //RECOMMENDATIONS//

        $recommandatations = [];

        $catproduitactuel = Produit::select('categorie_id')->where('id', $id)->first()->toArray();
        $catproduitactuel = $catproduitactuel['categorie_id'];

        //dd($collection[count($collection)-1]);
        if(!isset($_COOKIE['account']['account_id']))
        {
            $checkid = 9999;
        }
        else
        {
            $checkid = $_COOKIE['account']['account_id'];
        }

        $produitsRrecommandes = PivotProduitAime::select('pivot_produit_aimes.produit_id')
        ->where('compte_client_id', '!=', $checkid)
        ->where('produits.categorie_id', $catproduitactuel)
        ->leftJoin('produits', 'produits.id', 'pivot_produit_aimes.produit_id')
        ->inRandomOrder()
        ->get()->toArray();

        //SUPRRESSION DES DOUBLONS, PAR FONCTION CAR IMPOSSIBLE AVEC DISTINCT() A CAUSE DE INRANDOMORDER()
        //DANS LA REQUETE SQL

        $unique_pr = [];
        foreach ($produitsRrecommandes as $pr)
        {
            $isin = false;
            foreach ($unique_pr as $upr)
            {
                if($upr == $pr['produit_id'])
                {
                    $isin = true;
                }
            }
            if ($isin == false)
            {
                array_push($unique_pr, $pr['produit_id']);
            }
        }
        
        foreach ($unique_pr as $pr)
        {
            $leproduit = Produit::where('produits.id', $pr)
            ->leftJoin('photo_produits', 'photo_produits.produit_id', '=', 'produits.id')
            ->leftJoin('couleurs', 'photo_produits.couleur_id', '=', 'couleurs.id')
            ->leftJoin('pivot_unifiers', 'pivot_unifiers.produit_id', 'produits.id')
            ->get()->toArray();
            $leproduit = $leproduit[0];
            array_push($recommandatations, $leproduit);
        }

        //IMPORTANT : LE LEFT JOIN TRANSFORME LES CHAMPS SUIVANTS:
        // ID DEVIENT L'ID DE LA PHOTO DU PRODUIT, ET NON PLUS DU PRODUIT
        // PRODUIT_ID DEVIENT L'ID DU PRODUIT

        //if ($collectionArray == null){
        //    $collectionArray = PhotoProduit::leftJoin('produits', 'photo_produits.produit_id', '=', 'produits.id')
        //    ->leftJoin('couleurs', 'photo_produits.couleur_id', '=', 'couleurs.id')
        //    ->where('lib_produit', 'like', $collection[0]."%")
        //    ->where('produits.id', '!=', $id)
        //    ->get()
        //    ->toArray();
        //}

        //DERNIERES CONSULTATIONS//
        $listedc = [];

        $denieresconsults = PivotDernieresConsult::where('compte_client_id', $checkid)
        ->orderBy('created_at', 'desc')->get()->toArray();
        foreach ($denieresconsults as $dc)
        {
            $leproduit = Produit::where('produits.id', $dc['produit_id'])
            ->leftJoin('photo_produits', 'photo_produits.produit_id', '=', 'produits.id')
            ->leftJoin('couleurs', 'photo_produits.couleur_id', '=', 'couleurs.id')
            ->leftJoin('pivot_unifiers', 'pivot_unifiers.produit_id', 'produits.id')
            ->get()->toArray();
            $leproduit = $leproduit[0];
            array_push($listedc, $leproduit);
        }



        //IMPORTANT : LE LEFT JOIN TRANSFORME LES CHAMPS SUIVANTS:
        // ID DEVIENT L'ID DE LA PHOTO DU PRODUIT, ET NON PLUS DU PRODUIT
        // PRODUIT_ID DEVIENT L'ID DU PRODUIT


        //REGARDE SI LE PRODUIT EST DEJA DANS LES DERNIERES CONSULTS
        $isin = false;
        foreach ($listedc as $produitconsulte)
        {
            if ($produitconsulte['produit_id'] == $id)
            {
                $isin = true;
            }  
        }

        //METS LE PRODUIT DANS LES DERNIERES CONSULTS SI IL Y EST PAS DEJA
        if ($isin == false)
        {
            if (count($listedc) == 5)
            {
                PivotDernieresConsult::where('compte_client_id', $checkid)->
                where('produit_id', $denieresconsults[count($denieresconsults) - 1]['produit_id'])->
                delete();
            }

            if (isset($_COOKIE['account']['account_id']))
            {
                PivotDernieresConsult::create(
                    array(
                           'produit_id'     =>   $id, 
                           'compte_client_id'   =>  $_COOKIE['account']['account_id'] 
                    )
               );
            }

        }
        //SECTION AVIS//
        //--------------------------------------------------------------------------------------------------------------------------------//

        try {
            $produit_choisi = $id;

            $lesAvis['lesAvis'] = Avis::join('compte_clients', 'avis.compte_client_id', '=', 'compte_clients.id')
                ->join('note_avis', 'avis.note_avis_id', '=', 'note_avis.id')
                ->leftJoin('photo_produits', 'avis.id', '=', 'photo_produits.avis_id')
                ->leftJoin('reponse_societes', 'avis.reponse_societe_id', '=', 'reponse_societes.id')
                ->select('compte_clients.prenom', 'note_avis.note_avis', 'avis.titre_avis', 'detail_avis', 'date_avis', 'url_photo_produit', 'avis.reponse_societe_id')
                ->where('avis.produit_id', $produit_choisi)
                ->orderBy('date_avis', 'DESC')
                ->get();


            $photoProduits['photoProduits'] = PhotoProduit::where('produit_id', '=', $produit_choisi)->where('couleur_id', '=', $idCouleur)
                ->get()
                ->first();

            if ($produit_choisi == 0) {
                return redirect('/')->withErrors(["Erreur de chargement des avis."]);
            }

            $i = 0;
            foreach ($lesAvis['lesAvis'] as $unAvis) {
                $i += $unAvis->note_avis;
            }
            $nbAvisProduit = count($lesAvis['lesAvis']);

            $avisClient['photo'] = Avis::leftJoin('photo_produits', 'photo_produits.avis_id', '=', 'avis.id')
                ->whereNotNull('avis_id')
                ->get();

            // dd($avisClient['photo']);

            $aAchete = PivotLignePanier::join('commandes', 'pivot_ligne_paniers.commande_id', 'commandes.id')
            ->where('produit_id', '=', $id)->where('couleur_id', '=', $idCouleur)
            ->where('commandes.compte_client_id', '=', $checkid)
            ->get()
            ->first();

            $currentURL = Session::get('currentURL');

            if (isset($_GET['submited'])){
                $titreAvis = $_GET['avisTitre'];
                $contenuAvis = $_GET['avisContenu'];
                $noteAvis = $_COOKIE["LiaisonJsPhp"];

                if (!isset($_COOKIE['account']['account_id']))
                {
                    $avisClientPost = new Avis();
                    $avisClientPost->compte_client_id = $_COOKIE['account']['account_id'];
                    $avisClientPost->reponse_societe_id = null;
                    $avisClientPost->produit_id = $produit_choisi;
                    $avisClientPost->note_avis_id = $noteAvis;
                    $avisClientPost->titre_avis = $titreAvis;
                    $avisClientPost->detail_avis = $contenuAvis;
                }

                if(isset($_FILES['photoAvis'])){
                    $tempname = $_FILES['formAvis']['tmp_name'];
                    $filename = $_FILES['formAvis']['name'];
                    $folder = 'MilibooS301/public/assets/photoAvis'.$produit_choisi.'_'.$checkid.'_'.$filename;

                    dd($folder);
                }

                $auto = Avis::orderBy('id', 'desc')->first()->id;
                if (isset($_COOKIE['account']['account_id']))
                {
                    Avis::insert(['id'=>$auto+1, 'compte_client_id' =>$_COOKIE['account']['account_id'], 'reponse_societe_id' => null, 'produit_id' => $produit_choisi, 'note_avis_id' => $noteAvis, 'titre_avis' => $titreAvis, 'detail_avis' => $contenuAvis]);

                }
                return redirect($currentURL)->with('success', "Avis posté avec succes.");
            }

            //PRODUITS LIKES
            $listelikes = [];

            if(isset($_GET['like']))
            {
                if($_GET['like'] == 'like')
                {
                    $produitslikes = PivotProduitAime::where('compte_client_id', $checkid)
                    ->orderBy('created_at', 'desc')->get()->toArray();
                    foreach ($produitslikes as $pl)
                    {
                        $leproduit = Produit::where('produits.id', $pl['produit_id'])
                        ->leftJoin('photo_produits', 'photo_produits.produit_id', '=', 'produits.id')
                        ->leftJoin('couleurs', 'photo_produits.couleur_id', '=', 'couleurs.id')
                        ->leftJoin('pivot_unifiers', 'pivot_unifiers.produit_id', 'produits.id')
                        ->get()->toArray();
                        $leproduit = $leproduit[0];
                        array_push($listelikes, $leproduit);
                    }
    
           
                    //IMPORTANT : LE LEFT JOIN TRANSFORME LES CHAMPS SUIVANTS:
                    // ID DEVIENT L'ID DE LA PHOTO DU PRODUIT, ET NON PLUS DU PRODUIT
                    // PRODUIT_ID DEVIENT L'ID DU PRODUIT
            
            
                    //REGARDE SI LE PRODUIT EST DEJA DANS LES DERNIERES CONSULTS
                    $isin = false;
                    foreach ($listelikes as $produitlike)
                    {
                        if ($produitlike['produit_id'] == $id)
                        {
                            $isin = true;
                        }  
                    }
           
                    //METS LE PRODUIT DANS LES DERNIERES CONSULTS SI IL Y EST PAS DEJA
                    if ($isin == false && isset($_COOKIE['account']['account_id']))
                    {   
    
                        PivotProduitAime::create(
                            array(
                                   'compte_client_id'   =>  $_COOKIE['account']['account_id'], 
                                   'produit_id'     =>   $id
                            )
                       );
                    }
                }
                else
                {
                    PivotProduitAime::where('compte_client_id', $checkid)->
                    where('produit_id', $id)->
                    delete();
                }
            }



            // dd($listelikes);
  
        
            return view('product')
                //Partie Avis
                ->with('avisTableau', $lesAvis)
                ->with('nbAvisProduit', $nbAvisProduit)
                ->with('sumNotes', $i)
                ->with('produit_choisi', $produit_choisi)
                ->with('photoProduit', $photoProduits['photoProduits']['url_photo_produit'])
                ->with('pointsFidelite', $pointsFidelite)
                ->with('lesPhotosUnifier', $lesPhotosUnifier)
                ->with('aAchete', $aAchete)
                //Partie Produit
                ->with('produit', $produit)
                ->with('unifier', $unifier)
                ->with('libCategorie', $libCategorie)
                ->with('listProduits', $listToutesLesCouleurs)
                ->with('libProduit', $libProduit)
                //Partie Recommandation
                ->with('collectionArray', $recommandatations)
                //Partie Dernières Consultations 
                ->with('listedc', $listedc);
        } catch (Exception $e) {
            // return redirect('/')->withErrors(["Erreur de chargement des avis."]); 
        }
    }

    public function showResponse($id){
        if ($id =! null){
            $reponses = ReponseSociete::where('id', $id)->get();
            return view('product', compact('reponses'));
        }
    }   
}
