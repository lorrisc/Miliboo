<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produit;
use App\Models\PhotoProduit;
use App\Models\PivotUnifier;
use App\Http\Controllers\DetailProduct;

class EditProductsController extends Controller
{
    public function edit($id, $idCouleur)
    {
        $leproduit = Produit::where('id', $id)
        ->join('pivot_unifiers', 'produits.id' ,'pivot_unifiers.produit_id')
        ->first()->toArray();

        $promo = 0;
        if ($_GET['Pourcentage_de_promotion'] != null && $_GET['Pourcentage_de_promotion'] != "")
        {
            $promo = $_GET['Pourcentage_de_promotion'];
        }

        $date = $leproduit['created_at'];
        if ($_GET['Date_de_mise_de_stock'] != null && $_GET['Date_de_mise_de_stock'] != "")
        {
            $date = $_GET['Date_de_mise_de_stock'];
        }

        PivotUnifier::where('produit_id', $id)->where('couleur_id', $idCouleur)
        ->update(['created_at' => $date,
                  'promo' => 1 - ((int)$promo / 100),
                  'prix' => $leproduit['prix'] * (1 - ((int)$promo / 100))
        ]);

        if ($_GET['Mention'] != null)
        {
            Produit::where('produit_id', $id)
            ->update(['mention_id' => (int)$_GET['Mention']]);
        }








        
        $products = Produit::orderBy('id')->get()->toArray();

        $allproducts = (array)[];
        foreach ($products as $pr)
        {
            array_push($allproducts, $pr);
        }


        foreach (range(0, count($allproducts) - 1) as $i)
        {

            $p_ByColor = PivotUnifier::where('produit_id', $allproducts[$i]['id'])
            ->get()->toArray();

            array_push($allproducts[$i], $p_ByColor);

            foreach (range(0, count($allproducts[$i]['0']) - 1) as $j) {
                $couleur_id = $allproducts[$i]['0'][$j]['couleur_id'];
                $produit_img['produit_img'] = PhotoProduit::where('produit_id', $allproducts[$i]['0'][$j]['produit_id'])
                ->where('couleur_id', $couleur_id)->get()->toArray();
                foreach ($produit_img['produit_img'] as $ite) {
                    $item = (array)$allproducts[$i]['0'][$j];
                    array_push($allproducts[$i]['0'][$j], $ite);
                }

            }
        }
        return view('detailproduct')->with('monTableau', $allproducts);

    }

}
