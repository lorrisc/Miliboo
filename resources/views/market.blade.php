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


    <section id="userArticles">

        <article id="userArticles__topline">
            <h3>Les articles de mon panier :</h3>
            <div id="userArticles__topline__right">
                <h3>Quantité</h3>
                <h3>Supprimer</h3>
                <h3>Total</h3>
            </div>
        </article>

        <section id="userArticles__content">
            <?php

            use App\Models\Produit;
            use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Js;

            $pointsFidelite = 0;
            $totalInitialPrice = 0;
            $totalFinalPrice = 0;


            foreach (Cart::content() as $row) : ?>
                <article class="userArticles__content__art">

                    <div class="userArticles__content__left">
                        <div class="userArticles__content__left__img">
                            <a href="/produit/{{$row->options['productid']}}/{{$row->name}}/{{$row->options['colorid']}}">
                                <img src="{{$row->options['pathimg']}}" alt="image produit">
                            </a>
                        </div>
                        <div class="userArticles__content__left__details">
                            <a href="/produit/{{$row->options['productid']}}/{{$row->name}}/{{$row->options['colorid']}}">
                                <p class="lib_article">{{$row->name}}</p>
                            </a>

                            <p class="lib_price">{{$row->options['initialprice']}}€</p>
                            @if($row->options['promo'] < 1) <p class="promo"> <span class="promovalue">{{($row->options['promo']-1)*100}}%</span>soit <?php echo (round($row->options['initialprice'] - ($row->options['promo'] * $row->options['initialprice']), 2)) ?>€</p>
                                @endif
                        </div>
                    </div>
                    <div class="userArticles__content__right">
                        <div class="userArticles__content__right__qty">
                            <form action="/modifierqteproduit/{{$row->id}}" method="POST">
                                @csrf
                                <select name="qty" id="qty" class="normalinput" onchange="this.form.submit()">
                                    <?php
                                    $quantite = Produit::where('id', $row->options['productid'])->get(['qte_produit'])->toArray();
                                    for ($i = 1; $i <= $quantite[0]['qte_produit']; $i++) {
                                        echo "<option value=\"" . $i . "\"";
                                        if ($row->qty == $i) {
                                            echo "selected";
                                        }
                                        echo "> " . $i . "</option>";
                                    }
                                    ?>
                                </select>
                            </form>
                        </div>
                        <div class="userArticles__content__right__delete">
                            <form action="/retirerproduit/{{$row->id}}" method="POST">
                                @csrf
                                <button type="submit"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </div>
                        <div class="userArticles__content__right__price">
                            <p><?php echo (round($row->price * $row->qty, 2)); ?>€</p>
                        </div>
                    </div>
                </article>
            <?php

                $fig = (int) str_pad('1', 1, '0');
                $pointsFidelite += ((floor($row->price * 0.1 * $fig) / $fig) * $row->qty);

                $totalInitialPrice += ($row->options['initialprice'] * $row->qty);
                $totalFinalPrice += ($row->price * $row->qty);

            endforeach; ?>
            <?php
            if (isset($fidelityPointUse)) {
                $totalFinalPrice -= $fidelityPointUse;
            }
            ?>


        </section>

        <section id="userArticles__resum">

            <section id="userArticles__resum__left">
                <article id="userArticles__resum__left__fidelitypoint">
                    <h3>Point fidélité</h3>
                    <p><span class="maketfidelityvalue">{{$pointsFidelite}}€ offert</span> sur votre prochaine commande pour votre achat.</p>

                    @if(isset($fidelityPoint))
                    @if($fidelityPoint > 0)
                    <div id="accountFidelity">
                        <h3>point compte</h3>
                        <p><span class="maketfidelityvalue">{{$fidelityPoint}} euros</span> sont disponible sur votre compte.</p>
                        <p>Souhaitez vous en profiter ?</p>
                        <div>
                            <a href="/fidelityPointAdd/{{round($totalFinalPrice,0)}}/{{$fidelityPoint}}" class="normalbutton">Oui</a>
                            <a href="" class="normalbutton">Non</a>
                        </div>
                    </div>
                    @endif
                    @endif
                </article>
                <a href="/">
                    <i class="fa-solid fa-chevron-left fa-xs"></i>Continuer mes achats
                </a>
            </section>

            <section id="userArticles__resum__right">

                <article id="userArticles__resum__right__resum">
                    <h3>résumé de la commande</h3>

                    <div id="userArticles__resum__right__resum__values">
                        <div>
                            <p>Total des articles (Prix initial)</p>
                            <p><?php echo (round($totalInitialPrice, 2)); ?>€</p>
                        </div>

                        @if(($totalInitialPrice-$totalFinalPrice)>0)
                        <div>
                            <p>Remise totale</p>
                            <p>- <?php echo (round($totalInitialPrice - $totalFinalPrice, 2)); ?>€</p>
                        </div>
                        @endif

                        <div>
                            <p>Frais de livraison</p>
                            <p>Gratuit</p>
                        </div>
                        @if(isset($fidelityPointUse))
                        <div>
                            <p>Point de fidelite</p>
                            <p>- {{$fidelityPointUse}}€</p>
                        </div>
                        @endif
                        <div>
                            <p>Total de la commande</p>
                            <p><?php echo (round($totalFinalPrice, 2)) ?>€</p>
                        </div>
                    </div>
                </article>
                <!-- 
                    note à celui qui la validation de commande : une fois le formulaire validé, renvoyer dans un controller. Si l'utilisateur est connecté alors l'utilisateur est redirigé vers la page étape 2. Sinon redirigé vers la page de connexion (déjà existante). Il faut donc rajouter des variables et des conditions pour la connexion/création de compte. Une fois connecté redirigé vers l'étape 2.  
                LC
                -->
            </section>

        </section>

        <br>

        <?php
        $adressestockee = 0;
        ?>

        @if(isset($_COOKIE['account']['account_id']))
        <section id="pageAccount__infoperso__container__right">
            <article id="right__infoperso" class="infopersotype">
                <div id="right__infoperso__delivery" class="infopersotype__container infoperso__container__cadre">
                    <div class="container__topline">
                        <h3>mes adresses de livraison</h3>
                    </div>

                    <!-- SEE DELIVERIES -->
                    <section id="infopersodelivery__container">
                        @if($deliveries!=null)
                        @foreach($deliveries as $key => $delivery)
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
                            <div class="address__button">
                                <p>Sélectionner</p>
                                <form method="get" name="formselection">
                                    <input onchange="test(this.value)" name="selection" id="selection" value="{{$delivery['id']}}" type="checkbox" 
                                    class="normalbutton editdelivery"></input>
                                </form>

                                <script type="text/javascript">
                                    var a = 0;
                                    function test(id)
                                    {        
                                        document.cookie = "idadress" +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';           
                                        let adressescochees = document.querySelectorAll("input[type='checkbox']");
                                        let count = 0;
                                        adressescochees.forEach((box) => {
                                            if (box.checked === true) {
                                                count++
                                            }
                                        });

                                        if(count == 0)
                                        {
                                            let cochemin = getElementsByValue(id);
                                            console.log(cochemin)
                                            cochemin.checked = true
                                        }
                                        else if (count > 1)
                                        {
                                            let cochemax = document.querySelectorAll("input[type='checkbox']");
                                            cochemax.forEach((box) => {
                                                box.checked = false
                                            });

                                            let cochemin2 = getElementsByValue(id);
                                            cochemin2.checked = true
                                        }

                                        let finalresult = getElementsByValue(id);   
                                        console.log(finalresult.value);


                                        console.log("idadress" + finalresult.value)
                                        document.cookie = "idadress=" + finalresult.value
                                    }

                                    function getElementsByValue(value)
                                    {
                                        var allInputs = document.getElementsByTagName("input");
                                        for(var x=0;x<allInputs.length;x++)
                                            if(allInputs[x].value == value)
                                            res = allInputs[x]
                                        return res;
                                    }

                                    function check()
                                    {
                                        var a = 0;
                                        let regexcodecarte = /([0-9]{4}[-]){3}[0-9]{4}/
                                        let regexcryptogramme = /[0-9]{3}/
                                        let regexexpiration = /[0-9]{2}[-][0-9]{2}/

                                        let codecarte = document.getElementById('codecarte').value;
                                        let cryptogramme = document.getElementById('cryptogramme').value;
                                        let expiration = document.getElementById('expiration').value;

                                        let reussi = 1
                                        let checkamountchecked = 0
                                        let cochemax = document.querySelectorAll("input[type='checkbox']");
                                            cochemax.forEach((box) => {
                                                if (box.checked)
                                                {
                                                    checkamountchecked++
                                                }
                                            });

                                        console.log(checkamountchecked);
                                            
                                        if(checkamountchecked == 0)
                                        {
                                            console.log(3)
                                            alert('Choisissez au moins une adresse');
                                            reussi = 0
                                        }

                                        if(! codecarte.match(regexcodecarte) && reussi == 1)
                                        {
                                            alert('Le format du code de la carte est incorrect');
                                            reussi = 0
                                        }

                                        if(! cryptogramme.match(regexcryptogramme) && reussi == 1)
                                        {
                                            console.log(4)
                                            alert('Le format du cryptogramme est incorrect');
                                            reussi = 0
                                        }

                                        if(! expiration.match(regexexpiration) && reussi == 1)
                                        {
                                            alert("Le format de la date d'expiration est incorrect");
                                            reussi = 0
                                        }

                                        if(reussi == 1)
                                        {
                                            let form = document.getElementById('paiement');
                                            form.submit();
                                        }
                                    }

                                </script>

                            </div>
                        </div>
                        @endforeach
                        @endif
                    </section>
                    @endif
                    
                </div>
            </article>
        </section>

        <br>

        @if(isset($_COOKIE['account']['account_id']))
        <section id="userArticles__paiement">

            <article id="userArticles__paiement__article">
                <h3>Paiement</h3>

                <div id="userArticles__paiement__div">
                    <form action="/commande" method="post" id="paiement">
                    @csrf
                        <div id="userArticles__paiement__cb">
                            <p>Numéro de carte banquaire : </p>
                            <br>
                            <input type="text" id="codecarte" name="codecarte" placeholder="XXXX-XXXX-XXXX-XXXX" value="">
                        </div>

                        <div id="userArticles__paiement__cb">
                            <p>Cryptogramme :</p>
                            <input type="text" id="cryptogramme" name="cryptogramme" placeholder="XXX" value="">
                        </div>

                        <div id="userArticles__paiement__cb">
                            <p>Date d'expiration :</p>
                            <input type="text" id="expiration" name="expiration" placeholder="XX-XX" value="">
                        </div>

                    </form>
                    <button onclick=check() class="largebutton" id="submitcart">
                                Valider ma commande
                                <i class="fa-solid fa-chevron-right fa-xs"></i>
                            </button>
                        <!-- </a> -->
                </div>

            </article>


            <!-- 
                note à celui qui la validation de commande : une fois le formulaire validé, renvoyer dans un controller. Si l'utilisateur est connecté alors l'utilisateur est redirigé vers la page étape 2. Sinon redirigé vers la page de connexion (déjà existante). Il faut donc rajouter des variables et des conditions pour la connexion/création de compte. Une fois connecté redirigé vers l'étape 2.  
            LC
            -->
        </section>
        @else
        <div id="buttonNotConnect">
            <a href="{{route('connexion')}}" class="normalbutton">Se connecter pour finaliser la commande</a>
        </div>
        @endif
        
    </section>



</section>
@endsection


@section('script')
@endsection