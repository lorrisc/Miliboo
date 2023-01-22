@extends('layouts.app')

@section('style')
<link rel="stylesheet" href="/css/notconnected.css">

@endsection

@section('title')
Compte / Consultation informations personnelles
@endsection

@section('content')
<section  id="pageNotConnect" class="principalContainer">
    <p id="alertMessage">vous devez être connecté pour avoir accès à ces fonctionnalitées !</p>
    <div id="buttonNotConnect">
        <a href="{{route('home')}}" class="normalbutton">Retour à l'accueil</a>
        <a href="{{route('connexion')}}" class="normalbutton">Se connecter</a>
    </div>
</section>
@endsection

@section('script')
<script src="js/accountinfoperso.js"></script>
@endsection

