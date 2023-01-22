@extends('layouts.app')

@section('style')
<link rel="stylesheet" href="/css/marketempty.css">

@endsection

@section('title')
Panier
@endsection

@section('content')
<section id="pageMarket" class="principalContainer">
    <p id="emptyinfo">Votre panier est actuellement vide.</p>
    <div id="interrogationaideConn">
            <i class="fa-solid fa-circle-question fa-3x"></i>
        </div>
        <div id="helpCreeCompte">
                Pour pouvoir remplir votre panier, choisissez des produits dans notre navigation.
                Sur la fiche d'un produit, appuiyer sur j'achète pour l'ajouter à votre panier
        </div>
        <div id="myDialog">
</section>
@endsection


@section('script')
<script>
    let helpCreeCompte = document.querySelector('#interrogationaideConn');
    let helpCreeComptePopup = document.querySelector('#helpCreeCompte')

    helpCreeCompte.addEventListener("mouseover", () => {
        helpCreeComptePopup.classList.add('active')
    })

    helpCreeCompte.addEventListener("mouseout", () => {
        helpCreeComptePopup.classList.remove('active')
    })
</script>
@endsection