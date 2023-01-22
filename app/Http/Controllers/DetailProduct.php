<?php

namespace App\Http\Controllers;

use App\Models\PhotoProduit;
use App\Models\PivotUnifier;
use App\Models\Produit;
use Illuminate\Http\Request;

class DetailProduct extends Controller
{
    public function index()
    {
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
