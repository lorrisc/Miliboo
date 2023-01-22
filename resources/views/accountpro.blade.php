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
    @include('partials.accountpromenu')

    <section id="pageAccount__">
        @include('partials.accountwelcometext')
    </section>
</section>
@endsection

@section('script')

@endsection