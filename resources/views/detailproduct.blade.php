@extends('layouts.app')

@section('style')
<link rel="stylesheet" href="/css/consultproducts.css">
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

            // use Illuminate\Support\Carbon;
            // use App\Models\Commande;

            // echo "<section>";
            // echo "<label>Livraison</label>";
            // echo "<select name=livraison class=\"normalinput\" id=livraison onchange=\"this.form.submit()\">";
            // if (isset($_REQUEST['livraison']) && $_REQUEST['livraison'] == 'Tout type de livraison') {
            //     echo "<option value='Tout type de livraison' selected>Tout type de livraison</option>";
            // } else {
            //     echo "<option value='Tout type de livraison'>Tout type de livraison</option>";
            // }

            // if (isset($_REQUEST['livraison']) && $_REQUEST['livraison'] == 'Livraison normale uniquement') {
            //     echo "<option value='Livraison normale uniquement' selected>Livraison normale uniquement</option>";
            // } else {
            //     echo "<option value='Livraison normale uniquement'>Livraison normale uniquement</option>";
            // }

            // if (isset($_REQUEST['livraison']) && $_REQUEST['livraison'] == 'Livraison express') {
            //     echo "<option value='Livraison express' selected>Livraison express</option>";
            // } else {
            //     echo "<option value='Livraison express'>Livraison express</option>";
            // }

            use App\Models\Categorie;
            use App\Models\Couleur;
use App\Models\Mention;
use App\Models\PhotoProduit;
use App\Models\Produit;
use Carbon\Carbon;

            ?>
        </form>
    </div>

    <div id='resultscommandes'>
        <?php

        foreach ($monTableau as $monproduit) {
            // if ($lacommande['livraison_express'] == 1) {
            //     $lacommande['livraison_express'] = 'Livraison express';
            // } else {
            //     $lacommande['livraison_express'] = 'Livraison normale';
            // }

            $libCat = Categorie::select('lib_categorie')->where('id', $monproduit['categorie_id'])->first()->toArray();
            $libCat = $libCat['lib_categorie'];

            $photoproduit = PhotoProduit::select('url_photo_produit')->where('produit_id', $monproduit['id'])->first()->toArray();
            $photoproduit = $photoproduit['url_photo_produit'];

            echo "<table>";
            echo "<thead>";
            echo "<th>Produit : </th>";
            echo "<th>Nom du produit : </th>";
            echo "<th>Quantité en stock : </th>";
            echo "<th>Catégorie du produit : </th>";
            echo "</thead>";

            echo "<tr>";
            echo '<td id="limage"><img src="' . $photoproduit . '" /></td>';
            echo '<td>' . $monproduit['lib_produit'] . '</td>';
            echo '<td>' . $monproduit['qte_produit'] . '</td>';
            echo '<td>' . $libCat . '</td>';

            echo "</tr>";

            echo '<tr id="fusebutton">';
            echo '<td colspan="3">
                <form method="get">
                <button type="submit" name="developper'.$monproduit['id'].'"value="developper'.$monproduit['id'].'">Développer</button>
                </form>
                </td>';
            echo '</tr>';


            echo "</table>";


            // foreach (range(0, count($monproduit['0']) - 1) as $i)
            // {

            //     $libCouleur = Couleur::select('lib_couleur')->where('id', $monproduit['0'][$i]['couleur_id'])->first()->toArray();
            //     $libCouleur = $libCouleur['lib_couleur'];

            //     $photoproduit_c = PhotoProduit::select('url_photo_produit')->where('produit_id', $monproduit['id'])
            //     ->where('couleur_id', $monproduit['0'][$i]['couleur_id'])->first();

            //     if ($photoproduit_c != null)
            //     {
            //         $photoproduit_c = $photoproduit_c['url_photo_produit'];
            //     }
                

            //     echo '<tr id="soustableau">';

            //     if ($photoproduit_c != null)
            //     {
            //         echo '<td id="limage_c"><img src="' . $photoproduit_c . '" /></td>';
            //     }

            //     echo '<td id="soustableau">' . $monproduit['0'][$i]['prix'] . '</td>';
            //     echo '<td id="soustableau">' . $monproduit['0'][$i]['prix'] / $monproduit['0'][$i]['promo'] . '</td>';
            //     echo '<td id="soustableau">' . 100 * (1 - $monproduit['0'][$i]['promo']) . '</td>';
            //     echo '<td id="soustableau">' . $libCouleur . '</td>';

            //     echo '</tr>';
            // }

            $access = false;
            foreach (range(0, count($monproduit['0']) - 1) as $i)
            {
                if(isset($_GET['developper'.$monproduit['id'].'']) || isset($_GET['modifier'.$monproduit['id'].'c'.$monproduit['0'][$i]['couleur_id'].'']))
                $access = true;
            }

            if ($access == true)
            {
                echo "<table id='soustable'>";

                echo '<tr>';
    
                echo "<th>Coloris : </th>";
                echo "<th>Prix du coloris (sans promo) : </th>";
                echo "<th>Prix du coloris (avec promo) : </th>";
                echo "<th>Réduction (pourcentages) : </th>";
                echo "<th>Couleur : </th>";
                echo "<th>Sections : </th>";
    
                echo '</tr>';
                

                foreach (range(0, count($monproduit['0']) - 1) as $i)
                {
    
                    $libCouleur = Couleur::select('lib_couleur')->where('id', $monproduit['0'][$i]['couleur_id'])->first()->toArray();
                    $libCouleur = $libCouleur['lib_couleur'];
    
                    $photoproduit_c = PhotoProduit::select('url_photo_produit')->where('produit_id', $monproduit['id'])
                    ->where('couleur_id', $monproduit['0'][$i]['couleur_id'])->first();
    
                    if ($photoproduit_c != null)
                    {
                        $photoproduit_c = $photoproduit_c['url_photo_produit'];
                    }
                    
    
                    echo '<tr id="soustableau">';
    
                    if ($photoproduit_c != null)
                    {
                        echo '<td id="limage_c"><img src="' . $photoproduit_c . '" /></td>';
                    }
    
                    echo '<td id="soustableau">' . $monproduit['0'][$i]['prix'] / $monproduit['0'][$i]['promo'] . '</td>';
                    echo '<td id="soustableau">' . $monproduit['0'][$i]['prix'] . '</td>';
                    echo '<td id="soustableau">' . 100 * (1 - $monproduit['0'][$i]['promo']) . '</td>';
                    echo '<td id="soustableau">' . $libCouleur . '</td>';

                    //SECTIONS 
                    $lessections = null;

                    if ($monproduit['0'][$i]['promo'] != 1)
                    {
                        $lessections = 'Promotions<br>';
                    } 
                    if ($monproduit['mention_id'] == 1)
                    {
                        $lessections = $lessections.'Made in France<br>';
                    }
                    if ($monproduit['created_at'] > Carbon::today()->subMonths(2))
                    {
                        $lessections = $lessections.'Nouveauté';
                    }


                    echo '<td id="soustableau">' . $lessections . '</td>';
    
                    echo '</tr>';

                    echo "</tr>";

                    if (!isset($_GET['modifier'.$monproduit['id'].'c'.$monproduit['0'][$i]['couleur_id'].'']))
                    {
                        echo '<tr id="fusebutton">';
                        echo '<td colspan="6">
                        <form method="get">
                        <button type="submit" name="modifier'.$monproduit['id'].'c'.$monproduit['0'][$i]['couleur_id'].'"value="modifier'.$monproduit['id'].'c'.$monproduit['0'][$i]['couleur_id'].'">Modifier</button>
                        </form>
                        </td>';
                        echo '</tr>';
                    }


                    if(isset($_GET['modifier'.$monproduit['id'].'c'.$monproduit['0'][$i]['couleur_id'].'']))
                    {
                        echo "<form action='/editproducts/{$monproduit['id']}/{$monproduit['0'][$i]['couleur_id']}' method='get' id='editP'>";
                            echo "<tr>";
                            echo "<td colspan='2'>";
                            echo "<label>Mention</label>";
                            echo "<select name=Mention class=\"normalinput\" id=Mention>";
                            echo '<option value="null" selected>Aucune mention </option>';
                            $mention = Mention::select('id', 'mention')->get()->toArray();
                            foreach($mention as $m)
                            {
                                echo '<option value='.$m['id'].'> '.$m['mention'].' </option>';
                            }
                            echo "</select>";
                            echo "</td>"; 
                            
                            echo "<td colspan='2'>";
                            echo "<label>Promotion</label>";
                            echo "<br>";
                            echo "<input type='number' id='pourcentagepromo' min='0' max='100' name='Pourcentage de promotion' 
                            placeholder=" . (1 - $monproduit['0'][$i]['promo']) * 100 . " />";
                            echo "</td>";
                            
                            echo "<td colspan='2'>";
                            echo "<label>Date de mise de stock</label>";
                            echo "<br>";
                            echo "<input onchange='test(this.value)' type='text' id='date' name='Date de mise de stock' 
                            placeholder='Format YYYY-MM-DD'";
                            echo "</td>";
                            echo "</tr>"; 

                            echo "<tr><td colspan='6'>
                            <input type='submit' value='Valider les changements'>
                            </td></tr>";
                        echo "</form>";  
                    }




                }
                echo "</table>";
            }  
            echo "<br>";
            echo "<br>";   
        }



        ?>

        <script type="text/javascript">
            function test(regex)
            {    
                let regexverif = /[0-9]{4}[-][0-9]{2}[-][0-9]{2}/

                if(!regex.match(regexverif))
                {
                    alert('Le format du code de la carte est incorrect');
                }
            }

        </script>
    </div>

</section>
@endsection

@section('script')

@endsection