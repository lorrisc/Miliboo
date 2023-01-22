@extends('layouts.app')

@section('style')
<link rel="stylesheet" href="/css/consult.css">
<link rel="stylesheet" href="/css/color.css">

@endsection

@section('title')
Compte
@endsection

@section('content')
<section id="pageConsultation" class="principalContainer">

    <h3>Récapitulatif des commandes :</h3>

    <div id='filtres'>


        <a href="{{ route('comptepro')}}">
            <button class="largebutton">Retour</button>
        </a>
        <form method="get" id="filterconsults">
            <?php

            use Illuminate\Support\Carbon;
            use App\Models\Commande;

            echo "<section>";
            echo "<label>Livraison</label>";
            echo "<select name=livraison class=\"normalinput\" id=livraison onchange=\"this.form.submit()\">";
            if (isset($_REQUEST['livraison']) && $_REQUEST['livraison'] == 'Tout type de livraison') {
                echo "<option value='Tout type de livraison' selected>Tout type de livraison</option>";
            } else {
                echo "<option value='Tout type de livraison'>Tout type de livraison</option>";
            }

            if (isset($_REQUEST['livraison']) && $_REQUEST['livraison'] == 'Livraison normale uniquement') {
                echo "<option value='Livraison normale uniquement' selected>Livraison normale uniquement</option>";
            } else {
                echo "<option value='Livraison normale uniquement'>Livraison normale uniquement</option>";
            }

            if (isset($_REQUEST['livraison']) && $_REQUEST['livraison'] == 'Livraison express') {
                echo "<option value='Livraison express' selected>Livraison express</option>";
            } else {
                echo "<option value='Livraison express'>Livraison express</option>";
            }


            echo "</select>";
            echo "</section>";

            echo "<section>";
            echo "<label>Date Commande</label>";
            echo "<select name=Date id=Date class=\"normalinput\"  onchange=\"this.form.submit()\">";
            if (isset($_REQUEST['Date']) && $_REQUEST['Date'] == 'Deja passées') {
                echo "<option value='Deja passées' selected>Toutes dates confondues</option>";
            } else {
                echo "<option value='Deja passées'>Toutes dates confondues</option>";
            }

            if (isset($_REQUEST['Date']) && $_REQUEST['Date'] == 'Heure prochaine') {
                echo "<option value='Heure prochaine' selected>Heure prochaine</option>";
            } else {
                echo "<option value='Heure prochaine'>Heure prochaine</option>";
            }

            if (isset($_REQUEST['Date']) && $_REQUEST['Date'] == 'Demi journée prochaine') {
                echo "<option value='Demi journée prochaine' selected>Demi journée prochaine</option>";
            } else {
                echo "<option value='Demi journée prochaine'>Demi journée prochaine</option>";
            }

            if (isset($_REQUEST['Date']) && $_REQUEST['Date'] == 'Journée prochaine') {
                echo "<option value='Journée prochaine' selected>Journée prochaine</option>";
            } else {
                echo "<option value='Journée prochaine'>Journée prochaine</option>";
            }

            if (isset($_REQUEST['Date']) && $_REQUEST['Date'] == '3 prochains jours') {
                echo "<option value='3 prochains jours' selected>3 prochains jours</option>";
            } else {
                echo "<option value='3 prochains jours'>3 prochains jours</option>";
            }

            if (isset($_REQUEST['Date']) && $_REQUEST['Date'] == 'Deux semaines prochaines') {
                echo "<option value='Deux semaines prochaines' selected>Deux semaines prochaines</option>";
            } else {
                echo "<option value='Deux semaines prochaines'>Deux semaines prochaines</option>";
            }

            echo "</select>";
            echo "</section>";



            echo "<section>";
            echo "<label>Mode transport</label>";
            echo "<select name=Mode id=Mode class=\"normalinput\"  onchange=\"this.form.submit()\">";
            echo "<option value='Tous types de transports'>Tous types de transports</option>";

            $transports = Commande::select('transports.lib_transport')
                ->join('transports', 'transports.id', 'commandes.transport_id')
                ->distinct()->get()->toArray();

            foreach ($transports as $t) {
                if (isset($_REQUEST['Mode'])) {
                    if ($_REQUEST['Mode'] == $t['lib_transport']) {
                        echo ('<option value="' . $t['lib_transport'] . '"selected>' . $t['lib_transport'] . '</option>');
                    } else {
                        echo ('<option value="' . $t['lib_transport'] . '">' . $t['lib_transport'] . '</option>');
                    }
                }
            }

            echo "</select>";
            echo "</section>";

            echo "<section>";
            echo "<label>Transport domicile</label>";
            echo "<select name=Transport id=Transport class=\"normalinput\"  onchange=\"this.form.submit()\">";

            if (isset($_REQUEST['Transport']) && $_REQUEST['Transport'] == 'Toutes destinations de transports') {
                echo "<option value='Toutes destinations de transports' selected>Toutes destinations de transports</option>";
            } else {
                echo "<option value='Toutes destinations de transports'>Toutes destinations de transports</option>";
            }


            if (isset($_REQUEST['Transport']) && $_REQUEST['Transport'] == 'Transport à domicile') {
                echo "<option value='Transport à domicile' selected>Transport à domicile</option>";
            } else {
                echo "<option value='Transport à domicile'>Transport à domicile</option>";
            }


            if (isset($_REQUEST['Transport']) && $_REQUEST['Transport'] == 'Depôt') {
                echo "<option value='Depôt' selected>Depôt</option>";
            } else {
                echo "<option value='Depôt'>Depôt</option>";
            }

            echo "</select>";
            echo "</section>";

            ?>
        </form>
    </div>

    <div id='resultscommandes'>
        <?php

        echo "<table>";
        echo "<thead>";
        echo "<th>Nom produit</th>";
        echo "<th>Compte Client ID</th>";
        echo "<th>Type de paiement</th>";
        echo "<th>Type livreur</th>";
        echo "<th>Instruction</th>";
        echo "<th>Type livraison</th>";
        echo "<th>Statut Commande</th>";
        echo "<th>Date commande</th>";
        echo "<th>Lib transport</th>";
        echo "<th>Commande emporté ?</th>";
        echo "<th>SMS</th>";
        

        foreach ($commandes as $lacommande) {
            if ($lacommande['livraison_express'] == 1) {
                $lacommande['livraison_express'] = 'Livraison express';
            } else {
                $lacommande['livraison_express'] = 'Livraison normale';
            }
        
            $emporte = $lacommande['emporte'];
        
            echo "<tr>";
        
            echo '<td>' . $lacommande['lib_produit'] . '</td>';
            echo '<td>' . $lacommande['compte_client_id'] . '</td>';
            echo '<td>' . $lacommande['type_paiement'] . '</td>';
            if ($lacommande['nom_livreur'] == null) {
                echo '<td>Pas de livreur : Depôt</td>';
            } else {
                echo '<td>' . $lacommande['nom_livreur'] . '</td>';
            }
            echo '<td>' . $lacommande['instruction'] . '</td>';
            echo '<td>' . $lacommande['livraison_express'] . '</td>';
            echo '<td>' . $lacommande['statut_commande'] . '</td>';
            echo '<td>' . $lacommande['date_commande'] . '</td>';
            echo '<td>' . $lacommande['lib_transport'] . '</td>';
            ?>

            <td id="button">
                <form method="GET">
                    @csrf
                    @method('PATCH')
                    @if ($lacommande['statut_commande'] == 'En cours de livraison')
                        <input type="checkbox" name="emporte" value="1" checked disabled>                    
                    @elseif ($lacommande['statut_commande'] == "En cours d'expedition")
                        <input type="checkbox" name="emporte" value="1" checked disabled>                    
                    @elseif ($lacommande['statut_commande'] == 'Annulé')
                        <input type="checkbox" name="emporte" value="1" disabled>   
                    @elseif ($lacommande['statut_commande'] == "Prêt à l'envoi")
                        <input type="checkbox" type="submit" name="emporte" value="{{$lacommande['id']}}" {{ $emporte ? 'checked' : '' }}>
                        <button onclick="test(this.value)" value="{{$lacommande['id']}}" type="submit" id='butsms'>Enregistrer</button>
                    @endif
                </form>
            </td>
            
            <script type="text/javascript">
                function test(id)
                {
                    console.log(id);
                    document.cookie = "idcommande" +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';        
                    document.cookie = "idcommande=" + id;
                }
            </script>

            <?php
            if (isset($_COOKIE['idcommande']))
            {
                Commande::where('id', $_COOKIE['idcommande'])->update([
                    'statut_commande' => 'En cours de livraison',
                ]);
                header('/consultations');
            }
            ?>

                <td class="sms">
                    @if ($lacommande['statut_commande'] == "Prêt à l'envoi")
                        <form action="{{ route('/sms', ['id' => $lacommande['compte_client_id']]) }}" method="POST">
                        @csrf
                        <label for="message">Contenu du SMS :</label>
                        <textarea name="message" id="message" cols="30" rows="2"></textarea>
                        <button type="submit">Envoyer</button>
                        </form>                    
                    @endif
                </td>


            <?php
            echo "</tr>";
        }

        echo "</table>";
        

        ?>
        
    </div>


    <table>

    </table>

</section>
@endsection

@section('script')
<script src="js/sms.js"></script>
@endsection