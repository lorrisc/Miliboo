@extends('layouts.app')

@section('style')
<link rel="stylesheet" href="/css/account.css">
<link rel="stylesheet" href="/css/accountmenu.css">
<link rel="stylesheet" href="/css/accountinfoperso.css">
<link rel="stylesheet" href="/css/popupadress.css">

@endsection

@section('title')
Compte / Information personnel
@endsection

@section('content')

<section id="pageAccount" class="principalContainer">

    @include('partials.accountmenu')

    <section id="pageAccount__infoperso">

        @include('partials.accountwelcometext')

        <!-- retrieve first name user -->
        <?php

        use App\Models\Civilite;
        use App\Models\CompteClient;
        use App\Models\Ville;
        use App\Models\CodePostal;

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
        <section id="pageAccount__infoperso__container">
            <section id="pageAccount__infoperso__container__left">

                <!-- SEE PERSONAL INFORMATION -->
                <section id="pageAccount__infoperso__container__left__value" class="infoperso__container__cadre">

                    <div class="container__topline">
                        <h3>informations personnelles</h3>
                        <button class="normalbutton" id="buttonEditPersonalInfo">Modifier</button>
                    </div>

                    <p><span>{{$civilite_lib}}</span> <span>{{$account['prenom']}}</span> <span>{{$account['nom']}}</span></p>
                    <p>{{$account['email']}}</p>
                    <p>{{$account['tel']}}</p>
                    <p>{{$account['tel_portable']}}</p>

                    <div id="facturation">
                        <h4>Adresse de facturation</h4>
                        <p><span class="textMarginRight">{{$account['prenom']}}</span><span>{{$account['nom']}}</span></p>
                        <p>{{$account['adresse_client']}}</p>
                        <p><span class="textMarginRight">{{$lib_cp}}</span><span class="uppercase">{{$lib_ville}}</span></p>
                        <p class="uppercase">france</p>
                    </div>

                </section>

                <!-- POPUP PERSONAL INFORMATION -->
                <section id="popup__infoperso__classic" class="popup">
                    <form method="POST" action="{{ url('/compte_modification_information_personnelles')}}">
                        @csrf

                        <div class=" popup__title">
                            <h2>Modifier mes informations personnels</h2>
                            <button class="closeButton" type="reset">
                                <div></div>
                                <div></div>
                            </button>
                        </div>

                        <section class="popup__container">
                            <div class="line generalinfo">
                                <select name="edit__civility" id="edit__civility" class="largeinput formcivility">
                                    <?php

                                    if ($civilite_lib == "Mr") {
                                        echo "<option value=\"Mr\" selected>Mr</option>";
                                    } else {
                                        echo "<option value=\"Mr\">Mr</option>";
                                    }
                                    if ($civilite_lib == "Mlle") {
                                        echo "<option value=\"Mlle\" selected>Mlle</option>";
                                    } else {
                                        echo "<option value=\"Mlle\">Mlle</option>";
                                    }
                                    if ($civilite_lib == "Mme") {
                                        echo "<option value=\"Mme\" selected>Mme</option>";
                                    } else {
                                        echo "<option value=\"Mme\">Mme</option>";
                                    } ?>
                                </select>
                                <input type="text" name="edit__name" id="edit__name" placeholder="Nom" value="{{$account['nom']}}" class="largeinput">
                                <input type="text" name="edit__firstname" id="edit__firstname" placeholder="Prénom" value="{{$account['prenom']}}" class="largeinput">
                            </div>

                            <!-- <input type="date" name="edit__birthday" id="edit__birthday" value="01/01/2003" class="largeinput"> -->
                            <input type="email" name="edit__email" id="edit__email" placeholder="Adresse email" value="{{$account['email']}}" class="largeinput">


                            <input type="text" name="globaladress" id="globaladress" placeholder="Saisir votre adresse complète" class="largeinput fetchaddress">
                            <p class="errormessage" id="addresserror">Adresse introuvable.</p>
                            <div class="normalbutton searchadressbutton" id="searchadress">Rechercher votre adresse</div>



                            <input type="text" name="useradress" id="useradress" placeholder="Adresse, ville" class="largeinput unselectinput fetchaddressresult" value="{{$account['adresse_client']}}" readonly>

                            <div class="line formadress">
                                <input type="text" name="postalzip" id="postalzip" placeholder="Code postal" class="largeinput unselectinput fetchopstalzipresult" value="{{$lib_cp}}" readonly>
                                <input type="text" name="city" id="city" placeholder="Ville" class="largeinput unselectinput fetchcityresult" value="{{$lib_ville}}" readonly>
                                <select name="edit__country" id="edit__country" class="largeinput formcountry">
                                    <option value="france" selected>France</option>
                                    <option value="suisse" disabled>Suisse</option>
                                    <option value="allemagne" disabled>Allemagne</option>
                                </select>
                            </div>

                            <div class="formtel">
                                <div>
                                    <label for="edit__tel">Téléphone</label>
                                    <input type="tel" name="edit__tel" id="edit__tel" placeholder="Téléphone" value="{{$account['tel']}}" class="normalinput">
                                </div>
                                <div>
                                    <label for="edit__telport">Portable</label>
                                    <input type="telport" name="edit__telport" id="edit__telport" placeholder="Portable" value="{{$account['tel_portable']}}" class="normalinput">
                                </div>
                            </div>

                        </section>

                        <div class="infoperso__popup__validate">
                            <button type="submit" class="popupValidationButton normalbutton">Mettre à jour ces informations</button>
                        </div>

                    </form>
                </section>
            </section>
            <section id="pageAccount__infoperso__container__right">
                <article id="right__infoperso" class="infopersotype">
                    <div id="right__infoperso__delivery" class="infopersotype__container infoperso__container__cadre">
                        <div class="container__topline">
                            <h3>mes adresses de livraison</h3>
                            <button class="normalbutton" id="adddelivery">Ajouter une adresse</button>
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
                                    <button class="normalbutton editdelivery">Modifier</button>
                                    <form action="/deletedelivery/{{$delivery['id']}}" method="POST">
                                        @csrf
                                        <button class="normalbutton" type="submit">Supprimer</button>
                                    </form>
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </section>

                        <!-- POPUP DELIVERIES -->
                        <section id="infopersodelivery__containerpopup">
                            <!-- NEW DELIVERY -->
                            <section id="infopersodelivery__containerpopup__newdelivery" class="popup">
                                <form action="/newdelivery" method="POST">
                                    @csrf
                                    <div class="popup__title">
                                        <h2>Ajouter une adresse</h2>
                                        <button class="closeButton" type="reset">
                                            <div></div>
                                            <div></div>
                                        </button>
                                    </div>

                                    <section class="popup__container">
                                        <div class="line generalinfo">
                                            <select name="newdelivery__civility" id="newdelivery__civility" class="largeinput formcivility">
                                                <option value="Mr">Mr</option>
                                                <option value="Mlle">Mlle</option>
                                                <option value="Mme">Mme</option>
                                            </select>
                                            <input type="text" name="newdelivery__namuser" id="newdelivery__namuser" placeholder="Nom" class="largeinput">
                                            <input type="text" name="newdelivery__firstnamuser" id="newdelivery__firstnamuser" placeholder="Prénom" class="largeinput">
                                        </div>


                                        <div class="uniqueinputline">
                                            <input type="text" name="globaladressnew" id="globaladressnew" placeholder="Saisir votre adresse complète" class="largeinput fetchaddress">
                                        </div>
                                        <p class="errormessage" id="addresserror">Adresse introuvable.</p>
                                        <div class="normalbutton searchadressbutton" id="searchadressnew">Rechercher votre adresse</div>


                                        <div class="uniqueinputline">

                                            <input type="text" name="newdelivery__address" id="newdelivery__address" placeholder="Adresse" class="largeinput unselectinput fetchaddressresult" readonly>
                                        </div>

                                        <div class="line formadress">
                                            <input type="text" name="newdelivery__postalzip" id="newdelivery__postalzip" placeholder="Code postal" class="largeinput unselectinput fetchopstalzipresult" readonly>
                                            <input type="text" name="newdelivery__city" id="newdelivery__city" placeholder="Ville" class="largeinput unselectinput fetchcityresult" readonly>
                                            <select name="newdelivery__country" id="newdelivery__country" class="largeinput formcountry">
                                                <option value="france" selected>France</option>
                                                <option value="suisse">Suisse</option>
                                                <option value="allemagne">Allemagne</option>
                                            </select>
                                        </div>

                                        <div class="formtel">
                                            <div>
                                                <label for="newdelivery__tel">Téléphone</label>
                                                <input type="tel" name="newdelivery__tel" id="newdelivery__tel" placeholder="Téléphone" class="normalinput">
                                            </div>
                                            <div>
                                                <label for="newdelivery__telport">Portable</label>
                                                <input type="telport" name="newdelivery__telport" id="newdelivery__telport" placeholder="Portable" class="normalinput">
                                            </div>
                                        </div>

                                        <div class="addressname">
                                            <input type="text" name="newdelivery__addressname" id="newdelivery__addressname" placeholder="Nom de l'adresse" class="largeinput">
                                            <p>Donnez un nom à votre adresse afin de la retrouver plus facilement</p>
                                        </div>
                                    </section>

                                    <div class="infoperso__popup__validate">
                                        <button type="submit" class="popupValidationButton normalbutton">Mettre à jour ces informations</button>
                                    </div>
                                </form>
                            </section>
                            <section id="infopersodelivery__containerpopup__editdeliveries">
                                @foreach($deliveries as $key => $delivery)
                                <section class="popup infopersodelivery__containerpopup__editdeliveries">
                                    <form action="/editdelivery/{{$delivery['id']}}" action="POST">
                                        @csrf
                                        <div class="popup__title">
                                            <h2>Modifier mon adresse de livraison</h2>
                                            <button class="closeButton" type="reset">
                                                <div></div>
                                                <div></div>
                                            </button>
                                        </div>

                                        <section class="popup__container">

                                            <div class="line generalinfo">
                                                <select name="editdelivery__civility" id="editdelivery__civility" class="largeinput formcivility">
                                                    @if($delivery['civilite_lib'] == "Mr")
                                                    <option value="Mr" selected>Mr</option>
                                                    @else
                                                    <option value="Mr">Mr</option>
                                                    @endif
                                                    @if($delivery['civilite_lib'] == "Mlle")
                                                    <option value="Mlle" selected>Mlle</option>
                                                    @else
                                                    <option value="Mlle">Mlle</option>
                                                    @endif
                                                    @if($delivery['civilite_lib'] == "Mme")
                                                    <option value="Mme" selected>Mme</option>
                                                    @else
                                                    <option value="Mme">Mme</option>
                                                    @endif
                                                </select>
                                                <input type="text" name="editdelivery__namuser" id="editdelivery__namuser" placeholder="Nom" value="{{$delivery['nom']}}" class="largeinput">
                                                <input type="text" name="editdelivery__firstnamuser" id="editdelivery__firstnamuser" value="{{$delivery['prenom']}}" placeholder="Prénom" class="largeinput">
                                            </div>

                                            <div class="uniqueinputline">
                                                <input type="text" name="globaladressnew" id="globaladressnew" placeholder="Saisir votre adresse complète" class="largeinput fetchaddress">
                                            </div>
                                            <p class="errormessage" id="addresserror">Adresse introuvable.</p>
                                            <div class="normalbutton searchadressbutton" id="searchadressnew">Rechercher votre adresse</div>


                                            <input type="text" name="editdelivery__address" id="editdelivery__address" value="{{$delivery['adresse_livraison']}}" placeholder="Adresse" class="largeinput unselectinput fetchaddressresult" readonly>

                                            <div class="line formadress">
                                                <input type="text" name="editdelivery__postalzip" id="editdelivery__postalzip" value="{{$delivery['code_postal_lib']}}" placeholder="Code postal" class="largeinput unselectinput fetchopstalzipresult" readonly>
                                                <input type="text" name="editdelivery__city" id="editdelivery__city" value="{{$delivery['ville_lib']}}" placeholder="Ville" class="largeinput unselectinput fetchcityresult" readonly>
                                                <select name="editdelivery__country" id="editdelivery__country" class="largeinput formcountry">
                                                    <option value="france" selected>France</option>
                                                    <option value="suisse">Suisse</option>
                                                    <option value="allemagne">Allemagne</option>
                                                </select>
                                            </div>

                                            <div class="formtel">
                                                <div>
                                                    <label for="editdelivery__tel">Téléphone</label>
                                                    <input type="tel" name="editdelivery__tel" id="editdelivery__tel" placeholder="01 23 45 67 89" value="{{$delivery['tel']}}" class="normalinput">
                                                </div>
                                                <div>
                                                    <label for="editdelivery__telport">Portable</label>
                                                    <input type="telport" name="editdelivery__telport" id="editdelivery__telport" value="{{$delivery['tel_portable']}}" placeholder="06 12 34 56 78" class="normalinput">
                                                </div>
                                            </div>

                                            <div class="addressname">
                                                <input type="text" name="editdelivery__addressname" id="editdelivery__addressname" placeholder="Nom de l'adresse" class="largeinput" value="{{$delivery['nom_adresse']}}">
                                                <p>Donnez un nom à votre adresse afin de la retrouver plus facilement</p>
                                            </div>

                                        </section>

                                        <div class="infoperso__popup__validate">
                                            <button type="submit" class="popupValidationButton normalbutton">Mettre à jour ces informations</button>
                                        </div>

                                    </form>
                                </section>
                                @endforeach
                            </section>
                        </section>
                    </div>
                </article>
            </section>
        </section>
    </section>
</section>


<div class="backgroundpopup"></div>
@if ($errors->any())
<div class="errorContainer">
    @foreach ($errors -> all() as $error)
    <p>{{ $error }}</p>
    @endforeach

    <button class="closeButton">
        <div></div>
        <div></div>
    </button>
</div>
@endif
@if (session('success'))
<div class="sucessMessage">
    <p>{{ session('success') }}</p>

    <button class="closeButton">
        <div></div>
        <div></div>
    </button>
</div>
@endif

@endsection

@section('script')
<script src="js/accountinfoperso.js"></script>
<script src="js/adress.js"></script>
@endsection