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
        <h1>Mes commandes passées</h1>
    </section>

    <?php

    use App\Models\AdresseLivraison;
    use App\Models\Civilite;
    use App\Models\CompteClient;
    use App\Models\Ville;
    use App\Models\CodePostal;
    use App\Models\PivotLignePanier;
    ?>

    <?php
    foreach(range(0, count($commandupdate) - 1) as $i) :
        $address = AdresseLivraison::where('id', $commandupdate[$i]['id_adresse'])->first()->toArray();

        $codepostallib = CodePostal::select('lib_cp')->where('id', $address['code_postal_id'])->first()->toArray();
        $codepostallib = $codepostallib['lib_cp'];

        $villelib = Ville::select('lib_ville')->where('id', $address['ville_id'])->first()->toArray();
        $villelib = $villelib['lib_ville'];
    ?>

        <section id="userArticles">
            <article id="userArticles__topline">
                <h3>Livraison id : {{$commandupdate[$i]['id']}}</h3>
            </article>
        </section>
        <br><br>

        <section id="etatCommande">
            <article id="etatCommande__topline">
                <h3>Etat de la commande</h3>
                <br>
                <table id="tableetatcommande">
                    <tr>
                        <?php
                            $list = ['En cours de traitement', 'En cours de livraison', 'Livré'];
                            $rank = 0;
                            foreach ($list as $item)
                            {

                                if ($commandupdate[$i]["statut_commande"] == $item)
                                {
                                    echo('<th id="boldblack">' .$commandupdate[$i]["statut_commande"]. '</th>');
                                }
                                else
                                {
                                    echo('<th>' .$item. '</th>');
                                }

                                if ($rank != 2)
                                {
                                    echo("<th> >>> </th>");
                                }
                                $rank++;
                            }

                        ?>
                    </tr>
                </table>
            </article>
        </section>

        <section id="pageAccount__infoperso__container__right">
        <article id="right__infoperso" class="infopersotype">
            <div id="right__infoperso__delivery" class="infopersotype__container infoperso__container__cadre">
                <div class="container__topline">
                    <h3>adresse de livraison</h3>
                </div>

                <!-- SEE DELIVERIES -->
                <section id="infopersodelivery__container">
                    <div class="infopersodelivery__container__address">
                        <div class="infopersodelivery__container__address__left">
                            <h4> {{$address['nom_adresse']}}
                            </h4>
                            <div class="address__value">
                                <p><span class="textMarginRight"> {{$address['prenom']}}
                                    </span><span> {{$address['nom']}}
                                    </span></p>
                                <p> {{$address['adresse_livraison']}}
                                </p>
                                <p><span class="textMarginRight"> {{$codepostallib}}
                                    </span><span class="uppercase"> {{$villelib}}
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

    <?php
        foreach(range(0, count($commandupdate[$i]['0']) - 1) as $j) :
    ?>

    <section id="userArticles">
        <section id="userArticles__content">
            <article class="userArticles__content__art">

                <div class="userArticles__content__left">
                    <div class="userArticles__content__left__img">
                        <a href="/produit/{{$commandupdate[$i]['0'][$j]['produit_id']}}/{{$commandupdate[$i]['0'][$j]['1']}}/{{$commandupdate[$i]['0'][$j]['couleur_id']}}">
                            <img src="{{$commandupdate[$i]['0'][$j]['0']}}" alt="image produit">
                        </a>
                    </div>
                    <div class="userArticles__content__left__details">
                        <a href="/produit/{{$commandupdate[$i]['0'][$j]['produit_id']}}/{{$commandupdate[$i]['0'][$j]['1']}}/{{$commandupdate[$i]['0'][$j]['couleur_id']}}">
                            <p class="lib_article">{{$commandupdate[$i]['0'][$j]['1']}}</p>
                        </a>

                        <p class="lib_price">{{$commandupdate[$i]['0'][$j]['2']}}€</p>
                        @if($commandupdate[$i]['0'][$j]['3'] < 1) <p class="promo"> <span class="promovalue">{{($commandupdate[$i]['0'][$j]['3']-1)*100}}%</span>soit <?php echo (round($commandupdate[$i]['0'][$j]['2'] - ($commandupdate[$i]['0'][$j]['3'] * $commandupdate[$i]['0'][$j]['2']), 2)) ?>€</p>
                            @endif
                    </div>
                </div>
                <div class="userArticles__content__right">
                    <div class="userArticles__content__right__price">
                        <p><?php echo (round($commandupdate[$i]['0'][$j]['2'] * $commandupdate[$i]['0'][$j]['qte'], 2)). '€, ' . $commandupdate[$i]['0'][$j]['qte']. ' produit(s)' ?></p>
                    </div>
                </div>
            </article>
        </section>
    </section>
    <br><br><br>




    <?php
        endforeach;
    endforeach;
    ?>

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