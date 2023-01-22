@extends('layouts.app')

@section('style')
<link rel="stylesheet" href="/css/consult.css">
<link rel="stylesheet" href="/css/color.css">
<link rel="stylesheet" href="/css/resultatvente.css">

@endsection

@section('resultatventesparcategories')
Resultat vente Par categories
@endsection

@section('content')

<section id="pageConsultation" class="principalContainer">
    <div class="icone">
        <h3 class="texte">Résultat des ventes par catégories :</h3>

        <a href="{{ route('ventesparmois')}}">
            <button class="largebutton">Retour</button>
        </a>

        <table id="tab1">
            <thead>
                <tr>
                    <th>Catégories</th>
                    <th>Resultat Vente</th>
                </tr>
            </thead>

            <tbody>
                @foreach($tabResVentesProduits as $item)

                <tr>
                    <td id="gauche" width="50%">
                        <?php echo ($item->lib_categorie) ?>
                    </td>
                    <td width="50%">
                        <?php echo (round($item->sommeprix,2)) . " €" ?>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>

<div id="bandenoir2"></div>

@endsection

@section('script')
<script src="js/resultatvente.js"></script>
@endsection