@extends('layouts.app')

@section('style')
<link rel="stylesheet" href="/css/account.css">
<link rel="stylesheet" href="/css/accountmenu.css">
<link rel="stylesheet" href="/css/accountpassword.css">
<link rel="stylesheet" href="/css/infopassword.css">

@endsection

@section('title')
Compte / Mot de passe
@endsection

@section('content')

<section id="pageAccount" class="principalContainer">



    @include('partials.accountmenu')

    <section id="pageAccount__password">
        @include('partials.accountwelcometext')

        <form id="pageAccount__password__container" method="POST" action="{{ url('/edit_password')}}">
            @csrf
            <h2>Changer mon mot de passe</h2>

            <label for="editpassword__oldpass">Ancien mot de passe</label>
            <input type="password" name="editpassword__oldpass" id="editpassword__oldpass" class="normalinput">

            <label for="passwordfield">Nouveau mot de passe</label>
            <input type="password" name="passwordfield" id="passwordfield" class="normalinput">

            <article id="passwordValidationText">
                <p id="minchar">12 caractères</p>
                <p id="lowercase">1 minuscule</p>
                <p id="uppercase">1 majuscule</p>
                <p id="chiffre">1 chiffre</p>
                <p id="specialchar">1 caractère spécial</p>
                <p id="samepass">Confirmation du mot de passe</p>
            </article>

            <label for="passwordconfirmfield">Confirmer mot de passe</label>
            <input type="password" name="passwordfield_confirmation" id="passwordconfirmfield" class="normalinput">

            <button type="submit">Valider</button>
        </form>
    </section>
</section>

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
<script src="js/infopassword.js"></script>
@endsection