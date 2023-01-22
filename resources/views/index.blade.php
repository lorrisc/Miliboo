@extends('layouts.app')

@section('style')
<link rel="stylesheet" href="/css/home.css">

@endsection

@section('title')
Accueil
@endsection

@section('content')
<section class="principalContainer">

    @if (session('success'))
    <div class="sucessMessage">
        <p>{{ session('success') }}</p>

        <button class="closeButton">
            <div></div>
            <div></div>
        </button>
    </div>
    @endif

    <a href="/promotion">
        <img id="homepub" src="/assets/homenoel.jpg" alt="">
    </a>

    <div class="popupcookie">
        <div class="popupcookie__topbar">
            <h3>Nous prenons à coeur de protéger vos données</h3>
        </div>
        <div class="popupcookie__main">
            <p>Notre organisation et ses partenaires stockent et/ou accèdent à des informations sur votre appareil, telles que les identifiants uniques de cookies pour traiter les données personnelles. Vous pouvez accepter et gérer vos préférences à tout moment en cliquant sur Gérer mes préférences, y compris votre droit d’opposition lorsqu’un intérêt légitime est invoqué. Vos préférences seront signalées à nos partenaires et n’affecteront pas votre navigation. <a href="">Politique de protection des données personnelles</a></p>
        </div>
        <div class="popupcookie__bottom">
            <button class="normalbutton transparentbutton">Refuser</button>
            <button class="normalbutton transparentbutton">Paramétrer</button>
            <button class="normalbutton">Accepter</button>
        </div>
    </div>
</section>

@endsection

@section('script')

@endsection