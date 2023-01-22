@extends('layouts.app')

@section('style')
<link rel="stylesheet" href="/css/account.css">
<link rel="stylesheet" href="/css/accountmenu.css">

@endsection

@section('title')
Compte
@endsection

@section('content')
<section id="pageAccount" class="principalContainer">
    @include('partials.accountmenu')

    <section id="pageAccount__">
        @include('partials.accountwelcometext')
    </section>
</section>
@endsection

@section('script')
<script>
    let helpConnCompte = document.querySelector('#interrogationaideConn4');
    let helpConnComptePopup = document.querySelector('#helpConnCompte4')

    helpConnCompte.addEventListener("mouseover", () => {
        helpConnComptePopup.classList.add('active')
    })

    helpConnCompte.addEventListener("mouseout", () => {
        helpConnComptePopup.classList.remove('active')
    })
</script>
@endsection