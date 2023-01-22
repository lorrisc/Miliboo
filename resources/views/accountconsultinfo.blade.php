@extends('layouts.app')

@section('style')
<link rel="stylesheet" href="/css/account.css">
<link rel="stylesheet" href="/css/accountmenu.css">

@endsection

@section('title')
Compte / Consultation informations personnelles
@endsection

@section('content')

<section id="pageAccount" class="principalContainer">

    @include('partials.accountmenu')

    <section id="pageAccount__infopersoconsultation">
        <!-- 
consultation et possibilités de suppression de l'ensemble de ses informations personnelles

information personnelles possbiblement reccueuilli (table dans db): 
    (permet d'identifier le client):
        adresse de livraison (
            ville_id, civilite_id, 
            code_postal_id, 
            nom_adresse, 
            nom, 
            prenom, 
            adresse_livraison, 
            tel, 
            tel_portable)
        avis (
            titre_avis, 
            detail_avis)
        compte_clients (
            ville_id, 
            civilite_id, 
            code_postal_id, 
            email, 
            nom, 
            prenom, 
            adresse_client, 
            tel, 
            tel_portable, 
            num_carte, 
            date_exp ,
            crypthogramme)

    (ne permet pas d'identifier le client):
        commandes
        photo_produits
        pivot dernieres consult
        pivot ligne panier ensemble
        pivot ligne panier
        pivot produit aime
 -->

        <p>Ci-dessous toutes les informations personnelles qui peuvent permettre de vous identifier que nous avons précédemment recueuilli. Vous pouvez les supprimers, celle-ci seront donc totalement anonymisé, cela engendre la cloturation de votre compte Miliboo. Le bouton permettant la suppression de vos informations se situe en bas de page.</p>

        <article id="pageAccount__infopersoconsultation__account">
            <h3>Informations de votre compte</h3>
            <?php
            foreach ($accountInfo as $key => $value) {
                echo '<p>' . $key . ' : ' . $value . '</p>';
            }
            ?>
        </article>
        <article id="pageAccount__infopersoconsultation__deliveries">
            <h3>Adresse de livraison</h3>
        </article>
        <article id="pageAccount__infopersoconsultation__avis">
            <h3>Avis publié</h3>
        </article>



    </section>
</section>

@endsection

@section('script')
<script src="js/accountinfoperso.js"></script>
@endsection