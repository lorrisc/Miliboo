@extends('layouts.app')

@section('style')
<link rel="stylesheet" href="/css/result.css">
<link rel="stylesheet" href="/css/color.css">
@endsection

@section('title')
Recherche
@endsection

@section('content')

<section id="pageResult" class="principalContainer">
    <!-- results -->
    <section id="results">
        <!-- filter here -->

        <!-- result line -->
        <div id="resultsTop">
            <p><span id="numberOfProducts"></span>produits</p>
            <select name="trierpar" id="trierpar">
                <option value="">Trier par :</option>
                <option value="croissant">Prix Croissant</option>
                <option value="decroissant">Prix Décroissant</option>
            </select>
        </div>

        <!-- grid of products -->
        <section id="results__container">
        
            @foreach($monTableau as $key => $produit)
            <!-- <a href="#" class="productContainer" > -->
            <!-- voir bak"> -->
            <?php
            $countelement = count($produit);
                     //dd($produit);
            $urlphoto = $produit[0][0]->url_photo_produit;
            $prixproduit = $produit['prix'];
            $promoproduit = $produit['promo'];
            $libproduit = $produit[0]['lib_produit'];
            $idproduit = $produit['produit_id'];
            $idcouleur = $produit[0][0]->couleur_id;

            $libProduitFormat = str_replace(array('%', '@', '\'', ';', '<', '>', '/', ' '), ' ', $libproduit);
            ?>
            <article>
                <article class="productValue">
                    <a class="productContainer" href="/produit/{{$idproduit}}/{{$libProduitFormat}}/{{$idcouleur}}">
                        <div class="imgcontainer">
                            <img src="<?php echo ($urlphoto) ?>" alt="image produit">
                        </div>
                        @if(1 - $promoproduit)
                        <p class="promopercent"> <?php echo ("- " . (1 - $promoproduit) * 100 . "%") ?></p>
                        @endif
                        <p class="product__title"><?php echo ($libproduit) ?></p>
                        <div class="product__infoSupp">
                            <p class="infoSupp__expeditionInfo">Expedié en 24h/72h</p>
                        </div>
                    </a>
                    <div class="product__bottom">
                        @if(1 - $promoproduit)
                        <p class="productPrice"><?php echo round($prixproduit * $promoproduit, 2) ?>€ <span class="avantreduc"><?php echo $prixproduit ?> €</span></p>
                        @else
                        <p class="productPrice"><?php echo $prixproduit ?>€ </p>
                        @endif    
                        <div class="productColor">
                            <a href="/produit/{{$idproduit}}/{{$libProduitFormat}}/{{$monTableau[$key]['couleur_id']}}">
                                <div class="color color{{$monTableau[$key]['couleur_id']}}"></div>
                            </a>
                        </div>
                    </div>
                </article>
            </article>
            @endforeach

        </section>
    </section>
</section>
@endsection

@section('script')
<script src="js/result.js"></script>
@endsection