@extends('layouts.app')

@section('style')
<link rel="stylesheet" href="/css/popupadress.css">
<link rel="stylesheet" href="/css/boutiquesadd.css">

@endsection

@section('title')
Ajouter boutique
@endsection

@section('content')
<section id="pageBoutiquePro" class="principalContainer">
    <h3>Ajouter une boutique :</h3>
    <a href="{{ route('comptepro')}}">
        <button class="largebutton">Retour</button>
    </a>

    <form action="/addShop" method="post" id="addboutique">
        @csrf
        <div>
            <label for="titleboutique">Titre boutique :</label>
            <input type="text" name="titleboutique" id="titleboutique" class="normalinput">
        </div>

        <div>
            <label for="telboutique">Telephone :</label>
            <input type="tel" name="telboutique" id="telboutique" class="normalinput">
        </div>

        <div>
            <label for="mailboutique">Mail boutique :</label>
            <input type="email" name="mailboutique" id="mailboutique" class="normalinput">
        </div>

        <div>
            <label for="indicationboutique">Indication accès :</label>
            <input type="text" name="indicationboutique" id="indicationboutique" class="normalinput">
        </div>

        <div>
            <label for="globaladress">Adresse boutique :</label>
            <input type="text" name="globaladress" id="globaladress" placeholder="Saisir l'adresse complète" class="normalinput fetchaddress">
        </div>
        <p class="errormessage" id="addresserror">Adresse introuvable.</p>
        <div class="normalbutton" id="searchadress">Rechercher votre adresse</div>

        <div id="pageBoutiquePro__infosupaddress">
            <input type="text" name="useradress" id="useradress" placeholder="Adresse" class="normalinput unselectinput fetchaddressresult" readonly>
            <input type="text" name="postalzip" id="postalzip" placeholder="Code postal" class="normalinput unselectinput fetchopstalzipresult" readonly>
            <input type="text" name="city" id="city" placeholder="Ville" class="normalinput unselectinput fetchcityresult" readonly>
            <select name="country" id="country" class="normalinput">
                <option value="france">France</option>
                <option value="suisse" disabled>Suisse</option>
                <option value="allemagne" disabled>Allemagne</option>
            </select>
        </div>

        <button type="submit" class="largebutton">Ajouter adresse</button>

    </form>
</section>
@include('partials.popupadress')
@endsection


@section('script')
<script src="js/adress.js"></script>
@endsection