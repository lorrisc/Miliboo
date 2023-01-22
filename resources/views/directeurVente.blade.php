@extends('layouts.app')

@section('style')
<link rel="stylesheet" href="/css/consult.css">
<link rel="stylesheet" href="/css/color.css">
<link rel="stylesheet" href="/css/resultatvente.css">

@endsection

@section('resultatvente')
Resultat vente
@endsection

@section('content')

<?php
function mois($numMois = null)
{
	switch ($numMois) {
		case 1:
			$mois = "Janvier";
			break;
		case 2:
			$mois = "Février";
			break;
		case 3:
			$mois = "Mars";
			break;
		case 4:
			$mois = "Avril";
			break;
		case 5:
			$mois = "Mai";
			break;
		case 6:
			$mois = "Juin";
			break;
		case 7:
			$mois = "Juillet";
			break;
		case 8:
			$mois = "Août";
			break;
		case 9:
			$mois = "Septembre";
			break;
		case 10:
			$mois = "Octobre";
			break;
		case 11:
			$mois = "Novembre";
			break;
		case 12:
			$mois = "Décembre";
			break;
		default:
			return false;
	}
	return $mois;
}

?>

<section id="pageConsultation" class="principalContainer">
	<div class="icone">
		<h3>Résultat des ventes par mois :</h3>
		<a href="{{ route('comptepro')}}">
			<button class="largebutton">Retour</button>
		</a>
		<table id="tab1">
			<thead>
				<tr>
					<th>Date</th>
					<th>Resultat Vente</th>
				</tr>
			</thead>

			<tbody id="hover">
				@foreach($tabResVentes as $resVente)
				<?php
				$mois = $resVente->mois;
				$annee = $resVente->année
				?>
				
				<tr>
					<td id="gauche" width="50%">
						<?php echo '<a href="/ventesparcategories/' . $mois . "/" . $annee . '" >' . mois($resVente->mois) . ' ' . $annee . '</a>'; ?>
					</td>

					<td idth="50%">
						<?php echo '<a href="/ventesparcategories/' . $mois . "/" . $annee . '" >' . round($resVente->prix,2) . " €" . '</a>'; ?>
					</td>
				</tr>
				
				@endforeach
			</tbody>
		</table>
	</div>
</section>

@endsection

@section('script')
<script src="js/resultatvente.js"></script>
@endsection