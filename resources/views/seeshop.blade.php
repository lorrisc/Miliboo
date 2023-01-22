@extends('layouts.app')

@section('style')
<link rel="stylesheet" href="/css/seeshop.css">

@endsection

@section('title')
Boutiques
@endsection

@section('content')
<section id="pageBoutique" class="principalContainer">
    <section id="pageBoutique__boutiques">
        @foreach ($shops as $shop)
        <article class="boutique">
            <div class="boutique__titre">
                <i class="fa-solid fa-location-dot fa-xl"></i>
                <h2>{{ $shop->titre }}</h2>
            </div>

            <div class="boutique__adresse">
                <p>{{ $shop->adresse }}</p>
                <p>{{ $shop->lib_cp }} {{$shop->lib_ville}}</p>
            </div>

            <div class="boutique__contact">
                <h3>contact</h3>
                <p>{{ $shop->tel }}</p>
                <p>{{ $shop->mail }}</p>
            </div>

            <div class="boutique__acces">
                <h3>accès</h3>
                <p>{{ $shop->indication }}</p>
            </div>
        </article>
        @endforeach

    </section>
</section>
@endsection

@section('script')
@endsection