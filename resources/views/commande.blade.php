@extends('layouts.app')

@section('style')
<link rel="stylesheet" href="/css/market.css">
<link rel="stylesheet" href="/css/account.css">
<link rel="stylesheet" href="/css/accountmenu.css">
<link rel="stylesheet" href="/css/accountinfoperso.css">
<link rel="stylesheet" href="/css/popupadress.css">

@endsection

@section('title')
Panier
@endsection

@section('content')
<section id="pageMarket" class="principalContainer">
    <section id="topMarket">
        <h1>Résumé de votre commande</h1>
    </section>

    <section id="etatCommande">
        <article id="etatCommande__topline">
            <h3>Etat de la commande</h3>
            <br>
            <table id="tableetatcommande">
                <tr>
                    <th id="boldblack">En cours de traitement</th>
                    <th>>>></th>
                    <th>En cours de livraison</th>
                    <th>>>></th>
                    <th>Livré</th>
                </tr>
            </table>
        </article>
    </section>

    <?php

    use App\Models\Civilite;
    use App\Models\CompteClient;
    use App\Models\Ville;
    use App\Models\CodePostal;
    use App\Models\PivotLignePanier;

    $account_id = $_COOKIE['account']['account_id'];

    $account = CompteClient::Select('nom', 'prenom', 'email', 'adresse_client', 'tel', 'tel_portable')
    ->where('id', $_COOKIE['account']['account_id'])->first()->toArray();


    $lib_ville = Ville::select('lib_ville')->where('id', $_COOKIE['account']['account_id'])->first();
    $lib_ville = $lib_ville->lib_ville;

    $cp_client = CompteClient::Select('code_postal_id')->where('id', $_COOKIE['account']['account_id'])->first();
    $lib_cp = CodePostal::select('lib_cp')->where('id', $cp_client->code_postal_id)->first();
    $lib_cp = $lib_cp->lib_cp;

    $civilite_client = CompteClient::Select('civilite_id')->where('id', $_COOKIE['account']['account_id'])->first();
    $civilite_lib = Civilite::select('lib_civilite')->where('id', $civilite_client->civilite_id)->first();
    $civilite_lib = $civilite_lib->lib_civilite;

    ?>

    <section id="userArticles">

        <article id="userArticles__topline">
            <h3>Les articles de mon panier :</h3>
            <div id="userArticles__topline__right">
                <h3>Quantité</h3>
            </div>
        </article>

        <section id="userArticles__content">
            <?php

            foreach($commandupdate['0'] as $item) : ?>

                <article class="userArticles__content__art">

                    <div class="userArticles__content__left">
                        <div class="userArticles__content__left__img">
                            <a href="/produit/{{$item['produit_id']}}/{{$item['1']}}/{{$item['couleur_id']}}">
                                <img src="{{$item['0']}}" alt="image produit">
                            </a>
                        </div>
                        <div class="userArticles__content__left__details">
                            <a href="/produit/{{$item['produit_id']}}/{{$item['1']}}/{{$item['couleur_id']}}">
                                <p class="lib_article">{{$item['1']}}</p>
                            </a>

                            <p class="lib_price">{{$item['2']}}€</p>
                            @if($item['3'] < 1) <p class="promo"> <span class="promovalue">{{($item['3']-1)*100}}%</span>soit <?php echo (round($item['2'] - ($item['3'] * $item['2']), 2)) ?>€</p>
                                @endif
                        </div>
                    </div>
                    <div class="userArticles__content__right">
                        <div class="userArticles__content__right__price">
                            <p><?php echo (round($item['2'] * $item['qte'], 2)). '€, ' . $item['qte']. ' produit(s)' ?></p>
                        </div>
                    </div>
                </article>
            <?php

            endforeach; ?>
            <?php
            if (isset($fidelityPointUse)) {
                $totalFinalPrice -= $fidelityPointUse;
            }
            ?>


        </section>

    </section>

    <section id="pageAccount__infoperso__container__right">
        <article id="right__infoperso" class="infopersotype">
            <div id="right__infoperso__delivery" class="infopersotype__container infoperso__container__cadre">
                <div class="container__topline">
                    <h3>adresse de livraison</h3>
                </div>

                <!-- SEE DELIVERIES -->
                <section id="infopersodelivery__container">
                    <?php
                    $delivery = $deliveries[0];
                    ?>
                    <div class="infopersodelivery__container__address">
                        <div class="infopersodelivery__container__address__left">
                            <h4> {{$delivery['nom_adresse']}}
                            </h4>
                            <div class="address__value">
                                <p><span class="textMarginRight"> {{$delivery['prenom']}}
                                    </span><span> {{$delivery['nom']}}
                                    </span></p>
                                <p> {{$delivery['adresse_livraison']}}
                                </p>
                                <p><span class="textMarginRight"> {{$delivery['code_postal_lib']}}
                                    </span><span class="uppercase"> {{$delivery['ville_lib']}}
                                    </span></p>
                                <p class="uppercase">france</p>
                                <!--we considered in project the country is allways france-->
                            </div>
                        </div>
                    </div>
                </section>              
            </div>
        </article>
    </section>

    <section id="userArticles__resum">
        <section id="userArticles__resum__left">
            <a href="/">
                <i class="fa-solid fa-chevron-left fa-xs"></i>Continuer mes achats
            </a>
        </section>
    </section>



</section>
@endsection


@section('script')
@endsection