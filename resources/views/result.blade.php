@extends('layouts.app')

@section('style')
<link rel="stylesheet" href="/css/result.css">
<link rel="stylesheet" href="/css/color.css">
@endsection

@section('title')
Recherche
@endsection

@section('content')

{{ session()->forget('id_produit') }}

<section id="pageResult" class="principalContainer">
    @if ($monTableau == null)
    <div id="pathCategory">
        @if(!isset($lacategorie))
        <p>Désolé, nous n'avons pas trouvé de résultats correspondant à $searchtext</p>
        @else
        <p>Désolé, nous n'avons pas trouvé de résultats correspondant à {{$lacategorie[0]->lib_categorie}}</p>
        @endif
    </div>

    @else
    <div id="pathCategory">
        <?php
        echo ("Recherche : " . $searchtext);
        ?>
    </div>
    @endif

    @if (isset($paramlcm))
    <!-- presentation category -->
    <section id="topresult">
        <div id="topresult__left">
            <h1>{{$lacategorie[0]->lib_categorie}}</h1>
            <p>{{$lacategorie[0]->descr_cat}}</p>
        </div>
        <div id="topresult__right">
            <img src="/assets/imageCategoryDB/{{$lacategorie[0]->photo_path}}" alt="Image de présentation de la catégorie">
        </div>
    </section>
    @endif

    <!-- results -->
    <section id="results">
        <!-- filter here -->

        <div>
            <?php

            use App\Models\Categorie;
            use App\Models\Produit;
            use App\Models\Couleur;
            use Hamcrest\Core\IsNot;
            use Illuminate\Support\Facades\DB;

            // dd($filtervalue['tri']);
            if (isset($lacategorie)) {

                echo "<form action=\"/categoriefilter/" . $lacategorie[0]->id . " \" method=\"post\" id=\"filterresult\">";
            ?>@csrf<?php

                    echo "<section>";
                    echo "<label for=\"categories\">Type de produit</label>";
                    echo "<select name=\"categories\" id=\"categories\" onchange=\"this.form.submit()\" class=\"normalinput\">";

                    $catmerevalue = null;

                    $lacatmere = DB::table('categories')->select('categorie_id')->where('id', $lacategorie[0]->id)->orderBy('id')->get()->toArray();
                    $test = DB::table('categories')->select('id', 'categorie_id')->where('id', $lacatmere[0]->categorie_id)->get()->toArray();
                    if ($test[0]->categorie_id == NULL) {
                        $catmerevalue = $lacategorie[0]->id;
                    } else {
                        $catmerevalue = $test[0]->id;
                    }

                    if (isset($filtervalue) && $filtervalue['id'] == $catmerevalue) {
                        echo ('<option value=' . $catmerevalue . ' selected>Toutes categories</option>');
                    } else if (isset($filtervalue) && $filtervalue['id'] <> $catmerevalue) {
                        echo ('<option value=' . $catmerevalue . '>Toutes categories</option>');
                    } else {
                        echo ('<option value=' . $catmerevalue . '>Toutes categories</option>');
                    }

                    $lescategoriesmoyennes = DB::table('categories')->whereNotNull('categorie_id')->orderBy('lib_categorie')->get()->toArray();

                    foreach ($lescategoriesmoyennes as $catmoyenne) {
                        $catarraymoyenne = (array)$catmoyenne;
                        if ($catarraymoyenne['categorie_id'] == $catmerevalue) {
                            $arraycatmoyenne = (array)$catmoyenne;
                            $stringcatmoyenne = (string)$arraycatmoyenne['lib_categorie'];

                            $paramlcm = $catarraymoyenne['id'];

                            if ($catarraymoyenne['id'] == $lacategorie[0]->id) {
                                echo ('<option value="' . $arraycatmoyenne['id'] . '"selected>' . $stringcatmoyenne . '</option>');
                            } else {
                                echo ('<option value="' . $arraycatmoyenne['id'] . '">' . $stringcatmoyenne . '</option>');
                            }
                        }
                    }

                    echo "</select>";
                    echo "</section>";

                    // RECUPERE UNIQUEMENT LES MATIERES DES PRODUITS RENVOYEES
                    $matieres = [];
                    foreach ($monTableau as $monTab) {
                        $verifcouleurisintable = false;
                        foreach ($matieres as $matiereactuelle) {
                            if ($monTab['matiere'] == $matiereactuelle) {
                                $verifcouleurisintable = true;
                            }
                        }
                        if ($verifcouleurisintable == false) {

                            array_push($matieres, $monTab['matiere']);
                        }
                    }
                    $matieretrie = [];
                    foreach ($matieres as $key => $matiere) {
                        $matieretrie[] = array('lib' => $matiere);
                    }
                    
                    $columns = array_column($matieretrie, 'lib');
                    array_multisort($columns, SORT_ASC, $matieretrie);
                    
                    
                    
                    echo "<section>";
                    echo "<label for=\"matieres\">Matière</label>";
                    echo "<select name=\"matieres\" id=\"matieres\" onchange=\"this.form.submit()\" class=\"normalinput\">";
                    echo "<option value=\"\">Toutes matières</option>";
                    foreach ($matieretrie as $mat) {
                        if ($mat['lib'] == NULL) {
                            $mat['lib'] = 'Matiere non renseignée';
                        }
                        echo ('<option value="' . $mat['lib'] . '"');
                        if (isset($filtervalue)) {
                            if ($filtervalue['matieres'] == $mat['lib']) {
                                echo "selected >";
                            } else {
                                echo ">";
                            }
                        } else {
                            echo ">";
                        }
                        echo ($mat['lib'] . '</option>');
                    }
                    echo "</select>";
                    echo "</section>";



                    // RECUPERE UNIQUEMENT LES COULEURS DES PRODUITS RENVOYEES
                    $couleurs = [];
                    foreach ($monTableau as $monTab) {
                        foreach (range(0, count($monTab) - 39) as $i) {
                            $verifcouleurisintable = false;
                            foreach ($couleurs as $couleursactuelle) {
                                if ($monTab[$i]['couleur_id'] == $couleursactuelle['id']) {
                                    $verifcouleurisintable = true;
                                }
                            }
                            if ($verifcouleurisintable == false) {
                                $lacouleur = Couleur::where('id', $monTab[$i]['couleur_id'])->get()->toArray();
                                array_push($couleurs, $lacouleur[0]);
                            }
                        }
                    }

                    $couleurtrie = [];
                    foreach ($couleurs as $key => $color) {
                        $couleurtrie[] = array('id' => $color['id'], "lib" => $color['lib_couleur']);
                    }
                    
                    $columns = array_column($couleurtrie, 'lib');
                    array_multisort($columns, SORT_ASC, $couleurtrie);

                    echo "<section>";
                    echo "<label for=\"couleurs\">Couleur</label>";
                    echo "<select name=\"couleurs\" id=\"couleurs\" onchange=\"this.form.submit()\" class=\"normalinput\">";
                    echo "<option value=\"\">Toutes couleurs</option>";
                    foreach ($couleurtrie as $col) {
                        $arraycol = (array)$col;
                        $stringcol = (string)$arraycol['lib'];
                        $stringidcol = (string)$arraycol['id'];
                        // $stringcol = (string)$arraycol['lib_couleur'];
                        // $stringidcol = (string)$arraycol['id'];
                        echo ('<option value="' . $stringidcol . '"');
                        if (isset($filtervalue) && $filtervalue['lib_couleurs'] <> null) {
                            if ($filtervalue['lib_couleurs'][0]->lib_couleur == $stringcol) {
                                echo "selected >";
                            } else {
                                echo ">";
                            }
                        } else {
                            echo ">";
                        }
                        echo ($stringcol . '</option>');
                    }
                    echo "</select>";
                    echo "</section>";

                    echo "
                <section>
                    <label for=\"prixmin\">Prix</label>
                    <div id=\"filtreprice\">
                        <div>
                            <label for=\"prixmin\">Min</label>
                            <input type=\"text\" id=\"prixmin\" name=\"prixmin\" placeholder=\"39.99\" value=\"";
                    if (isset($filtervalue)) {
                        echo $filtervalue['prixmin'];
                    }
                    echo "\"onchange=\"this.form.submit()\" class=\" normalinput\"\">
                    </div>
                    <div>
                        <label for=\"prixmax\">Max</label>
                            <input type=\"text\" id=\"prixmax\" name=\"prixmax\" placeholder=\"3499.99\" value=\"";
                    if (isset($filtervalue)) {
                        echo $filtervalue['prixmax'];
                    }
                    echo "\"onchange=\"this.form.submit() \" class=\"normalinput\"\">
                    </div>
                    </div>
                </section>

                <!-- <input type=\" submit\" value=\"valider\"> -->

                <section>
                    <label for=\"triPrix\">Tri par prix</label>
                    <select name=\"triPrix\" id=triPrix onchange=\"this.form.submit()\" class=\"normalinput\">\"";
                    if (empty($filtervalue)) {
                        echo ('<option value="PrixDefault" selected>Prix par défault</option>');
                        echo ('<option value="PrixCroissant">Tri par prix croissant</option>\"');
                        echo ('<option value="PrixDecroissant">Tri par prix décroissant</option>\"');
                    } else {
                        if ($filtervalue['tri'] == 'PrixDefault') {
                            echo ('<option value="PrixDefault" selected>Prix par défault</option>');
                        } else {
                            echo ('<option value="PrixDefault">Prix par défault</option>');
                        }

                        if ($filtervalue['tri'] == 'PrixCroissant') {
                            echo ('<option value="PrixCroissant" selected>Tri par prix croissant</option>\"');
                        } else {
                            echo ('<option value="PrixCroissant">Tri par prix croissant</option>\"');
                        }

                        if ($filtervalue['tri'] == 'PrixDecroissant') {
                            echo ('<option value="PrixDecroissant" selected>Tri par prix décroissant</option>\"');
                        } else {
                            echo ('<option value="PrixDecroissant">Tri par prix décroissant</option>\"');
                        }
                    }
                }
                echo ('
                    </select>
                </section>
            </form>')
                    ?>
        </div>


        <!-- result line -->
        <div id="resultsTop">
            <p><span id="numberOfProducts"></span>produits</p>
        </div>

        <!-- grid of products -->
        <section id="results__container">

            @foreach($monTableau as $key => $produit)
            <!-- <a href="#" class="productContainer" > -->
            <!-- voir bak"> -->
            <?php

            $countelement = count($produit);
            $urlphoto = $produit[0][0]->url_photo_produit;
            $prixproduit = $produit[0]['prix'];
            $libproduit = $produit['lib_produit'];
            $idproduit = $produit[0]['produit_id'];
            $idcouleur = $produit[0]['couleur_id'];

            $libProduitFormat = str_replace(array('%', '@', '\'', ';', '<', '>', '/', ' '), ' ', $libproduit);
            ?>

            <article class="productContainer">
                <article class="productValue">
                    <a class="productContainer" href="/produit/{{$idproduit}}/{{$libProduitFormat}}/{{$idcouleur}}">
                        <div class="imgcontainer">
                            <img src="<?php echo ($urlphoto) ?>" alt="image produit">
                        </div>
                        <p class="product__title"><?php echo ($libproduit) ?></p>
                        <div class="product__infoSupp">
                            <p class="infoSupp__expeditionInfo">Expedié en 24h/72h</p>
                        </div>
                    </a>
                    <div class="product__bottom">
                        <p class="productPrice"><span class="price"><?php echo round($prixproduit, 2) ?></span> €</p>
                        <div class="productColor">
                            <!-- <d class="color"></d> -->
                            <!-- <div class="color"></div>
                                <div class="color"></div>
                                <div class="color"></div>
                                <div class="morecolor">+ 3</div> -->


                            @php($j = 0)
                            @php($more = 0)
                            @for ($i = 38; $i < $countelement; $i++) @if($j<3) <a href="/produit/{{$idproduit}}/{{$libProduitFormat}}/{{$monTableau[$key][$j]['couleur_id']}}">
                                <div class="color color{{$monTableau[$key][$j]['couleur_id']}}"></div>
                                </a>
                                @else
                                @php($more = $more + 1)
                                @endif
                                @php($j=$j +1)
                                @endfor
                                @if($more>1)
                                <a class="productContainer" href="/produit/{{$idproduit}}/{{$libProduitFormat}}/{{$idcouleur}}">
                                    <div class="morecolor">+ {{$more}}</div>
                                </a>
                                @endif
                        </div>
                    </div>
                </article>
            </article>
            @endforeach

        </section>
    </section>
</section>
@endsection

@section('script')
<script src="/js/result.js"></script>
<script src="/js/filter.js"></script>
@endsection