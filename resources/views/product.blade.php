@extends('layouts.app')

@section('style')
<link rel="stylesheet" href="/css/product.css">
<link rel="stylesheet" href="/css/color.css">
<link rel="stylesheet" href="/css/style.css">



@endsection

@section('title')
Accueil
@endsection

@section('content')

<section id="pageProduct" class="principalContainer">
    <?php

    use App\Http\Controllers\ProduitsLikes;
    use App\Models\PivotProduitAime;
    use App\Models\Produit;
    use Illuminate\Support\Facades\Session;

    $splitted = explode(' ', $libCategorie);
    ?>

    <div class="backgroundpopup">
    </div>
    <div id="photoContainer">
        <div id="croixPhoto">
            <button class="closeButton" type="reset">
                <div></div>
                <div></div>
            </button>
        </div>
        <div>
            <div class="globalArrow" id="leftArrow"></div>
            <img class="photoCarousel photoProduitAffiche" src="" alt="PhotoProduit" id="photoAffichee">
            <div class="globalArrow" id="rightArrow"></div>
        </div>
    </div>

    <p id="pathCategory">Meuble Miliboo / {{$splitted[0]}} / {{$libCategorie}} / {{$libProduit}}</p>

    <section id="productPresentation" class="">
        <article>
            @foreach ($lesPhotosUnifier as $photo)
            <img class="photoProduitAffiche" src="{{$photo->url_photo_produit}}" alt="PhotoProduit">
            @endforeach
        </article>
        <article id="productCard">
            <h2>{{$libProduit}}</h2>
            <a id="descriptionlink" href="#description">Description détaillée</a>

            <div id="productcolorcontainer">
                <p>Colori(s) disponible(s):</p>
                <div class="colorcontainer">
                    <?php
                    if (count($listProduits) == 1) {
                        echo '<p>Ce produit est à couleur unique.</p>';
                    } else {
                        $substring = explode('/', url()->current());

                        foreach ($listProduits as $color) {
                            //On peut vouloir voir l'element qu'on consulte dans la liste des couleurs si on commente le if
                            if ((int)$color['couleur_id'] !== (int)$produit['couleur_id']) {
                                echo '<a href="/produit/' . $produit_choisi . '/' . $libProduit . '/' . $color['couleur_id'] . '">';
                                echo '<div class="color color' . $color["couleur_id"] . '"></div></a>';
                                // echo '<a id=a'. $color["couleur_id"] .' href='.$substring[0].'/'.$substring[1].'/'.$substring[2].'/'.$substring[3].'/'.$substring[4].'/'.$substring[5].'/'.$color['couleur_id'].'></a>';
                            }
                        }
                    }
                    ?>
                </div>
                <div id="default-color"></div>
                <a href="#"></a>
            </div>

            <div id="productprice">
                @if($unifier[0]['promo'] == 1)
                <p class="actualprice">{{$unifier[0]['prix']}} €</p>
                @else

                <p class="actualprice">{{ round($unifier[0]['prix']*$unifier[0]['promo'], 2)}} €</p>
                <p class="originalprice"> {{$unifier[0]['prix']}} €</p>
                @endif
            </div>

            <div id="deliveryinformation">
                <div>
                    <i class="fa-solid fa-check"></i>
                    <p>Livraison gratuite</p>
                </div>
                <div>
                    <i class="fa-solid fa-truck"></i>
                    <p>Expédié sous 24h/72h</p>
                </div>
            </div>

            <div id="basket">
                <form action="/ajouterproduit/{{$unifier[0]['produit_id']}}/{{$unifier[0]['couleur_id']}}" method="POST">
                    @csrf
                    <select name="nbArticles" id="nbArticles" class="largebutton">
                        <?php
                        $quantite = Produit::where('id', $unifier[0]['produit_id'])->get(['qte_produit'])->toArray();

                        for ($i = 1; $i <= $quantite[0]['qte_produit']; $i++) {
                            echo "<option value='$i'>$i</option>";
                        }
                        ?>
                    </select>
                    <button type="submit" class="largebutton">J'achète</button>
                </form>
            </div>
            <div id="fidelitypoint">
                <i class="fa-solid fa-gift fa-2xl"></i>
                <div>
                    <p><span>Points de fidélité</span> sur votre prochaine commande pour votre achat</p>
                    <p><span id="fidelitypoint__price">
                            <?php
                            echo $pointsFidelite
                            ?>€</span> OFFERT</p>
                </div>
            </div>

            <div id="likebutton">
                <p id="liketext">Liker le produit</p>
                <div id="interrogationaide">
                    <i class="fa-solid fa-circle-question fa-3x"></i>
                </div>
                <div id="helpConnCompte">
                    <ul>
                        <li>
                            Vous pouvez liker ce produit en cliquant sur le coeur rouge.
                            Mais il faut êtes connecté à votre compte.
                        </li>
                        <li>
                            Vous pouvez consulter vos produits favoris dans l’onglet « Mes favoris » en haut à droite.
                        </li>
                    </ul>
                </div>
                <form value="like" action="" method="get" name='like'>
                    <?php
                    if (isset($_COOKIE['account']['account_id'])) {
                        $isliked = PivotProduitAime::where('produit_id', $produit_choisi)
                            ->where('compte_client_id', $_COOKIE['account']['account_id'])
                            ->first();

                        if ($isliked == null) {
                            echo ('<button type="submit" value="like" id="like" name="like">♡</button>');
                        } else {
                            echo ('<button type="submit" value="liked" id="liked" name="like">♡</button>');
                        }
                    } else {
                        echo ('<button type="submit" value="like" id="like" name="like">♡</button>');
                    }

                    ?>
                </form>
            </div>
        </article>

    </section>
    <div id="informationsproduit">
        <div id="description">
            <h2 id="description__title">Description</h2>
            <div id="descriptionContainer">
                <div id="descriptionText">
                    <p class="firstele">
                        <?php echo $unifier[0]['text_descr'] ?>
                    </p>
                </div>
                <div id="descriptionAT">
                    <h3>Aspect technique</h3>

                    <p>Dimensions totales :
                        @if(isset($produit['d_tot_longueur']))
                        L{{$produit['d_tot_longueur']}} x
                        @endif
                        @if(isset($produit['d_tot_profondeur']))
                        P{{$produit['d_tot_profondeur']}} x
                        @endif
                        @if(isset($produit['d_tot_hauteur']))
                        H{{$produit['d_tot_hauteur']}}
                        @endif
                        cm</p>

                    <p>Dimensions assise :
                        @if(isset($produit['d_ass_longueur']))
                        L{{$produit['d_ass_longueur']}} x
                        @endif
                        @if(isset($produit['d_ass_profondeur']))
                        P{{$produit['d_ass_profondeur']}} x
                        @endif
                        @if(isset($produit['d_ass_hauteur']))
                        H{{$produit['d_ass_hauteur']}}
                        @endif
                        cm</p>

                    <p>Dimensions dossier :
                        @if(isset($produit['d_dos_longueur']))
                        L{{$produit['d_dos_longueur']}} x
                        @endif
                        @if(isset($produit['d_dos_profondeur']))
                        P{{$produit['d_dos_profondeur']}} x
                        @endif
                        @if(isset($produit['d_dos_hauteur']))
                        H{{$produit['d_dos_hauteur']}}
                        @endif
                        cm</p>
                    <?php
                    if ($produit['poids_max'] != null) {
                        echo '<p>Poids maximum supporté : {{$produit[\'poids_max\']}}</p>';
                    }
                    ?>
                    @if(isset($produit['matiere']))
                    <p>Matières : {{$produit['matiere']}}</p>
                    @endif
                    <p>Dimensions du colis :
                        @if(isset($produit['d_longueur_colis']))
                        L{{$produit['d_longueur_colis']}} x
                        @endif
                        @if(isset($produit['d_profondeur_colis']))
                        P{{$produit['d_profondeur_colis']}} x
                        @endif
                        @if(isset($produit['d_hauteur_colis']))
                        H{{$produit['d_hauteur_colis']}}
                        @endif
                        cm</p>
                    @if(isset($produit['d_poids_colis']))
                    <p>Poids du colis : {{$produit['d_poids_colis']}}kg</p>
                    @endif
                </div>
                <div id="descriptionRecycle">
                    <p class="firstele"><i class="fa-solid fa-recycle fa-xl"></i>Ce produit peut être, au choix, réemployé ou recyclé.</p>
                    <p class="firstele"> Si vous souhaitez recycler votre produit, vous pouvez vous rendre dans l'un des points de collecte dont la liste est disponible sur <a class="cursor" href="https://www.maisondutri.fr/je-donne-je-recycle-pres-de-chez-moi/" target="_blank">Maison du tri.</a></p>
                </div>
                <div>
                    <h3 class="cursor" id="clickJsFun">Voir toutes les photos.</h3>
                </div>
            </div>
        </div>
    </div>


    <section id="aviscontainer">

        <h2 id="jsp">Avis client</button></h2>
        <div id="interrogationaideConn">
            <i class="fa-solid fa-circle-question fa-3x"></i>
        </div>
        <div id="helpCreeCompte">
            <ul>
                <li>
                    Pour pouvoir laisser un avis sur ce produit, vous devez l'avoir déjà commandé.
                </li>
                <li>
                    Si c'est le cas, vous pouvez en étant connecté à votre compte client, laissez un avis dans le formulaire ci-dessous.
                </li>
            </ul>
            <br> Vous pouvez même ajouter une image à votre commentaire.
        </div>
        <div id="myDialog">

            <p>Contenu de la boîte de dialogue</p>
        </div>

        <div id="aviscontainer__top">
            <div id="aviscontainer__top__img">
                <img src="{{ $photoProduit }}" alt="Photo produit">
            </div>
            <div class="separatorline"></div>
            @if ($nbAvisProduit != 0)
            <?php $moyenneAvis = round($sumNotes / $nbAvisProduit, 1); ?>

            <div id="aviscontainer__top__avis">
                <h2>{{ $moyenneAvis }} / 4</h2>

                <?php
                if ($moyenneAvis > 3.75) {
                    echo '<div class="star">
                    <i class=\'fa-solid fa-star fa-lg\'></i>
                    <i class=\'fa-solid fa-star fa-lg\'></i>
                    <i class=\'fa-solid fa-star fa-lg\'></i>
                    <i class=\'fa-solid fa-star fa-lg\'></i>
                    </div>
                    ';
                } else if ($moyenneAvis >= 3.25) {
                    echo '<div class="star">
                    <i class=\'fa-solid fa-star fa-lg\'></i>
                    <i class=\'fa-solid fa-star fa-lg\'></i>
                    <i class=\'fa-solid fa-star fa-lg\'></i>
                    <i class=\'fa-solid fa-star-half-stroke fa-lg\'></i>
                    </div>

                    ';
                } else if ($moyenneAvis >= 2.75) {
                    echo '<div class="star">
                    <i class=\'fa-solid fa-star fa-lg\'></i>
                    <i class=\'fa-solid fa-star fa-lg\'></i>
                    <i class=\'fa-solid fa-star fa-lg\'></i>
                    <i class=\'fa-regular fa-star fa-lg\'></i>
                    </div>
                    ';
                } else if ($moyenneAvis >= 2.25) {
                    echo '<div class="star">
                    <i class=\'fa-solid fa-star fa-lg\'></i>
                    <i class=\'fa-solid fa-star fa-lg\'></i>
                    <i class=\'fa-solid fa-star-half-stroke fa-lg\'></i>
                    <i class=\'fa-regular fa-star fa-lg\'></i>
                    </div>
                    ';
                } else if ($moyenneAvis >= 1.75) {
                    echo '<div class="star">
                    <i class=\'fa-solid fa-star fa-lg\'></i>
                    <i class=\'fa-solid fa-star fa-lg\'></i>
                    <i class=\'fa-regular fa-star fa-lg\'></i>
                    <i class=\'fa-regular fa-star fa-lg\'></i>
                    </div>
                    ';
                } else if ($moyenneAvis >= 1.25) {
                    echo '<div class="star">
                    <i class=\'fa-solid fa-star fa-lg\'></i>
                    <i class=\'fa-solid fa-star-half-stroke fa-lg\'></i>
                    <i class=\'fa-regular fa-star fa-lg\'></i>
                    <i class=\'fa-regular fa-star fa-lg\'></i>
                    </div>
                    ';
                } else if ($moyenneAvis >= 0.75) {
                    echo '<div class="star">
                    <i class=\'fa-solid fa-star fa-lg\'></i>
                    <i class=\'fa-regular fa-star fa-lg\'></i>
                    <i class=\'fa-regular fa-star fa-lg\'></i>
                    <i class=\'fa-regular fa-star fa-lg\'></i>
                    </div>
                    ';
                } else {
                    echo '<div class="star">
                    <i class=\'fa-solid fa-star-half-stroke fa-lg\'></i>
                    <i class=\'fa-regular fa-star fa-lg\'></i>
                    <i class=\'fa-regular fa-star fa-lg\'></i>
                    <i class=\'fa-regular fa-star fa-lg\'></i>
                    </div>
                    ';
                }
                ?>

                <p id="numberavis"><?php echo $nbAvisProduit ?> avis</p>
            </div>
        </div>

        <!-- 
        <section id="premier-avis-produit">

            <?php

            $nomClient = $avisTableau['lesAvis'][0]->prenom;
            $noteClient = $avisTableau['lesAvis'][0]->note_avis;

            $titreAvis = $avisTableau['lesAvis'][0]->titre_avis;
            $contenuAvis = $avisTableau['lesAvis'][0]->detail_avis;
            $dateAvis = $avisTableau['lesAvis'][0]->date_avis;
            $imgAvis = $avisTableau['lesAvis'][0]->url_photo_produit;

            $dateFormatSpliter = explode(' ', $avisTableau['lesAvis'][0]->date_avis);
            $dateFormatSplited = explode('-', $dateFormatSpliter[0]);

            $mois = '';
            switch ($dateFormatSplited[1]) {
                case '01':
                    $mois = 'Janvier';
                    break;
                case '02':
                    $mois = 'Février';
                    break;
                case '03':
                    $mois = 'Mars';
                    break;
                case '04':
                    $mois = 'Avril';
                    break;
                case '05':
                    $mois = 'Mai';
                    break;
                case '06':
                    $mois = 'Juin';
                    break;
                case '07':
                    $mois = 'Juillet';
                    break;
                case '08':
                    $mois = 'Août';
                    break;
                case '09':
                    $mois = 'Septembre';
                    break;
                case '10':
                    $mois = 'Octobre';
                    break;
                case '11':
                    $mois = 'Novembre';
                    break;
                case '12':
                    $mois = 'Décembre';
                    break;
            }

            $noteEtoile = '';
            switch ($noteClient) {
                case 1:
                    $noteEtoile = '
                    <i class=\'fa-solid fa-star  fa-sm\'></i>
                    <i class=\'fa-regular fa-star fa-sm\'></i>
                    <i class=\'fa-regular fa-star fa-sm\'></i>
                    <i class=\'fa-regular fa-star fa-sm\'></i>
                    ';
                    break;
                case 2:
                    $noteEtoile = '
                    <i class=\'fa-solid fa-star fa-sm\'></i>
                    <i class=\'fa-solid fa-star fa-sm\'></i>
                    <i class=\'fa-regular fa-star fa-sm\'></i>
                    <i class=\'fa-regular fa-star fa-sm\'></i>
                    ';
                    break;
                case 3:
                    $noteEtoile = '
                    <i class=\'fa-solid fa-star fa-sm\'></i>
                    <i class=\'fa-solid fa-star fa-sm\'></i>
                    <i class=\'fa-solid fa-star fa-sm\'></i>
                    <i class=\'fa-regular fa-star fa-sm\'></i>
                    ';
                    break;
                case 4:
                    $noteEtoile = '
                    <i class=\'fa-solid fa-star fa-sm\'></i>
                    <i class=\'fa-solid fa-star fa-sm\'></i>
                    <i class=\'fa-solid fa-star fa-sm\'></i>
                    <i class=\'fa-solid fa-star fa-sm\'></i>
                    ';
                    break;
                default:
                    break;
            }

            // <p>' . $noteClient . ' - ' . $noteEtoile . '</p>
            echo '
            <article class="product__avis">
                <div class="product__avis__left">
                    <p>' . $nomClient . '</p>
                    <p>' . $noteEtoile . '</p>

                </div>
                <div class="product__avis__middle">
                    <p>' . $titreAvis . '</p>
                    <p>' . $contenuAvis . '</p>
                </div>
                <div class = "product__avis__photo__middle">';
            if ($imgAvis != null) {
                echo '<img class="imgAvisFormat" src="' . $imgAvis . '">';
            }
            echo '</div>
                <div class="product__avis__right">
                <p>' . $dateFormatSplited[2] . ' ' . $mois . ' ' . $dateFormatSplited[0] . '</p>
                </div>
            </article>';
            ?>
        </section> -->

        <section id="reste-avis-produit">

            <?php
            if (count($avisTableau['lesAvis']) > 1) {
                for ($j = 0; $j <= count($avisTableau['lesAvis']) - 1; $j++) {
                    $nomClient = $avisTableau['lesAvis'][$j]->prenom;
                    $noteClient = $avisTableau['lesAvis'][$j]->note_avis;
                    $titreAvis = $avisTableau['lesAvis'][$j]->titre_avis;
                    $contenuAvis = $avisTableau['lesAvis'][$j]->detail_avis;
                    $dateAvis = $avisTableau['lesAvis'][$j]->date_avis;
                    $imgAvis = $avisTableau['lesAvis'][$j]->url_photo_produit;
                    $idReponse = $avisTableau['lesAvis'][$j]->reponse_societe_id;
                    // dd($nomClient);
                    // dd($idReponse);

                    $dateFormatSpliter = explode(' ', $avisTableau['lesAvis'][$j]->date_avis);
                    $dateFormatSplited = explode('-', $dateFormatSpliter[0]);


                    $mois = '';
                    switch ($dateFormatSplited[1]) {
                        case '01':
                            $mois = 'Janvier';
                            break;
                        case '02':
                            $mois = 'Février';
                            break;
                        case '03':
                            $mois = 'Mars';
                            break;
                        case '04':
                            $mois = 'Avril';
                            break;
                        case '05':
                            $mois = 'Mai';
                            break;
                        case '06':
                            $mois = 'Juin';
                            break;
                        case '07':
                            $mois = 'Juillet';
                            break;
                        case '08':
                            $mois = 'Août';
                            break;
                        case '09':
                            $mois = 'Septembre';
                            break;
                        case '10':
                            $mois = 'Octobre';
                            break;
                        case '11':
                            $mois = 'Novembre';
                            break;
                        case '12':
                            $mois = 'Décembre';
                            break;
                    }

                    $noteEtoile = '';
                    switch ($noteClient) {
                        case 1:
                            $noteEtoile = '
                                <i class=\'fa-solid fa-star fa-sm\'></i>
                                <i class=\'fa-regular fa-star fa-sm\'></i>
                                <i class=\'fa-regular fa-star fa-sm\'></i>
                                <i class=\'fa-regular fa-star fa-sm\'></i>
                                ';
                            break;
                        case 2:
                            $noteEtoile = '
                                <i class=\'fa-solid fa-star fa-sm\'></i>
                                <i class=\'fa-solid fa-star fa-sm\'></i>
                                <i class=\'fa-regular fa-star fa-sm\'></i>
                                <i class=\'fa-regular fa-star fa-sm\'></i>
                                ';
                            break;
                        case 3:
                            $noteEtoile = '
                                <i class=\'fa-solid fa-star fa-sm\'></i>
                                <i class=\'fa-solid fa-star fa-sm\'></i>
                                <i class=\'fa-solid fa-star fa-sm\'></i>
                                <i class=\'fa-regular fa-star fa-sm\'></i>
                                ';
                            break;
                        case 4:
                            $noteEtoile = '
                                <i class=\'fa-solid fa-star fa-sm\'></i>
                                <i class=\'fa-solid fa-star fa-sm\'></i>
                                <i class=\'fa-solid fa-star fa-sm\'></i>
                                <i class=\'fa-solid fa-star fa-sm\'></i>
                                ';
                            break;
                        default:
                            break;
                    }

                    // <p>' . $noteClient . ' - ' . $noteEtoile . '</p>
                    echo '
                <article class="product__avis">
                    <div class="product__avis__left">
                        <p>' . $nomClient . '</p>
                        <p>' . $noteEtoile . '</p>

                    </div>
                    <div class="product__avis__middle">
                        <p>' . $titreAvis . '</p>
                        <p>' . $contenuAvis . '</p>
                    </div>
                    <div class = "product__avis__photo__middle">';
                    if ($imgAvis != null) {
                        echo '<img class="imgAvisFormat" src="' . $imgAvis . '">';
                    }
                    echo '</div>
                    <div class="product__avis__right">
                    <p>' . $dateFormatSplited[2] . ' ' . $mois . ' ' . $dateFormatSplited[0] . '</p>
                    </div>  
                </article>';

                    // echo '<article class="reponse">';
                    // echo '<a href="/produit/{$idReponse}">Voir les réponses</a>';
                    // if (isset($idReponse) && isset($reponses)) {
                    //     echo '<h1>{{ $avis->titreAvis }}</h1>';
                    //     foreach ($reponses as $reponse) {
                    //         echo '<p>{{ $reponse->detail_reponse }}</p>';
                    //     }
                    // }
                    // echo '</article>';
                }
            }
            ?>


        </section>
        @else
        <section>
            <p>Il n'y a pas encore d'avis sur ce produit.</p>
        </section>
        @endif
    </section>
    <section id="nouvelAvis">
        <h2>Ajouter un commentaire:</h2>

        @if(!isset($_COOKIE['account']['account_id']))
        <p>Il faut être connecté pour publier un avis.</p>

        @elseif($_COOKIE['account']['account_id'] != null and isset($aAchete->produit_id))
        @if($aAchete->produit_id == $produit_choisi)
        <form method="GET" action="<?php echo url()->current(); ?>" id="formAvis" name="formAvis">
            @csrf

            <section id="topavis">
                <div id="topavis__title">
                    <label for="avisTitre">Titre de votre avis :</label>
                    <input type="text" name="avisTitre" id="avisTitre" placeholder="Très satisfait" required="L'avis doit avoir un titre." class="largeinput">
                </div>
                <div id="noteavis__container">
                    <label for="">Note de votre avis :</label>
                    <div id="noteavis">
                        <i class='fa-solid fa-star fa-sm choisisEtoile fa-xl'></i>
                        <i class='fa-solid fa-star fa-sm choisisEtoile fa-xl'></i>
                        <i class='fa-regular fa-star fa-sm choisisEtoile fa-xl'></i>
                        <i class='fa-regular fa-star fa-sm choisisEtoile fa-xl'></i>
                    </div>
                </div>
            </section>

            <div>
                <label for="avisContenu">Détail de votre avis :</label>
                <textarea id="avisContenu" name="avisContenu" cols="90" rows="5" placeholder="Ce produit m'a convaincu, car ..." required="L'avis doit avoir un contenu." class="largeinput"></textarea>
            </div>

            <input type="file" name="photoAvis" id="photoAvis" accept=".jpg, .jpeg, .png" />
        </form>

        <?php
        Session::put('currentURL', url()->current());
        ?>
        </form>
        <button type="submit" form="formAvis" value="submit" id="submited" name="submited" class="largebutton">Publier</button>
        @endif
        @else
        <p>Vous devez acheter cet article pour pouvoir poster un avis.</p>

        @endif
    </section>

    <section id="recommandations">
        <p class="presentation__section">RECOMMANDATION:</p>
        <div id="produitEnRapport">
            <div id="produits__rapport__container">
                <?php
                $a = 0;
                if (count($collectionArray) == 1)
                    $a = 1;
                elseif (count($collectionArray) == 2)
                    $a = 2;
                elseif (count($collectionArray) == 3)
                    $a = 3;
                elseif (count($collectionArray) >= 4)
                    $a = 4;
                if (count($collectionArray) == 0)
                    $a = 0;
                ?>

                @for ($i = 0; $i < $a; $i++) <?php
                                                $libProduitFormat = str_replace(array('%', '@', '\'', ';', '<', '>', '/', ' '), ' ', $collectionArray[$i]['lib_produit']);
                                                $url_produit = "/produit/" . $collectionArray[$i]['produit_id'] . "/" . $libProduitFormat . "/" . $collectionArray[$i]['couleur_id']; ?> <a href="{{$url_produit}}">
                    <div class="elt__produit__en__rapport">
                        <img class="photo__produit__en__rapport" src="{{$collectionArray[$i]['url_photo_produit']}}">
                        <p class="elt__produit__en__rapport__p">{{$collectionArray[$i]['lib_produit']}}</p>
                        <div class="prix__container__recommandation">
                            <p class="p__prix__ap__reduc__recommandation">{{round($collectionArray[$i]['prix'] * $collectionArray[$i]['promo'], 2)}}€</p>
                        </div>
                        @if ($collectionArray[$i]['promo'] != 1)
                        <div class="prix__container__recommandation">
                            <p class="p__prix__av__reduc__recommandation">{{$collectionArray[$i]['prix']}}€ -{{(1-$collectionArray[$i]['promo'])*100}}%</p>
                        </div>
                        @endif

                    </div>
                    </a>
                    @endfor
            </div>
        </div>
    </section>

    <section id="dernieresconsults">
        <p class="presentation__section">DERNIERES CONSULTATIONS:</p>
        <div id="produitEnRapport">
            <div id="produits__rapport__container">
                <?php
                $a = 0;
                if (count($listedc) == 1)
                    $a = 1;
                elseif (count($listedc) == 2)
                    $a = 2;
                elseif (count($listedc) == 3)
                    $a = 3;
                elseif (count($listedc) >= 4)
                    $a = 4;
                if (count($listedc) == 0)
                    $a = 0;
                ?>

                @for ($i = 0; $i < $a; $i++) <?php
                                                $libProduitFormat = str_replace(array('%', '@', '\'', ';', '<', '>', '/', ' '), ' ', $listedc[$i]['lib_produit']);
                                                $url_produit = "/produit/" . $listedc[$i]['produit_id'] . "/" . $libProduitFormat . "/" . $listedc[$i]['couleur_id']; ?> <a href="{{$url_produit}}">
                    <div class="elt__produit__en__rapport">
                        <img class="photo__produit__en__rapport" src="{{$listedc[$i]['url_photo_produit']}}">
                        <p class="elt__produit__en__rapport__p">{{$listedc[$i]['lib_produit']}}</p>
                        <div class="prix__container__recommandation">
                            <p class="p__prix__ap__reduc__recommandation">{{round($listedc[$i]['prix'] * $listedc[$i]['promo'], 2)}}€</p>
                        </div>
                        @if ($listedc[$i]['promo'] != 1)
                        <div class="prix__container__recommandation">
                            <p class="p__prix__av__reduc__recommandation">{{$listedc[$i]['prix']}}€ -{{(1-$listedc[$i]['promo'])*100}}%</p>
                        </div>
                        @endif

                    </div>
                    </a>
                    @endfor
            </div>
        </div>
    </section>


</section>










<script>
    function setCookie(nom, valeur, expire, chemin, domaine, securite) {
        document.cookie = nom + ' = ' + escape(valeur) + '  ' +
            ((expire == undefined) ? '' : ('; expires = ' + expire.toGMTString())) +
            ((chemin == undefined) ? '' : ('; path = ' + chemin)) +
            ((domaine == undefined) ? '' : ('; domain = ' + domaine)) +
            ((securite == true) ? '; secure' : '');
    }

    addEventListener("load", (event) => {
        let listeEtoiles = document.querySelectorAll('.choisisEtoile');
        let starSelector = 2;

        var dtExpire = new Date();
        dtExpire.setTime(dtExpire.getTime() + 3600 * 84);
        setCookie('LiaisonJsPhp', starSelector, dtExpire, '/');

        for (let i = 0; i < listeEtoiles.length; i++) {
            listeEtoiles[i].addEventListener('click', (event) => {

                switch (listeEtoiles[i]) {
                    case listeEtoiles[0]:
                        starSelector = 1

                        listeEtoiles[0].classList.remove("fa-regular");
                        listeEtoiles[1].classList.remove("fa-solid");
                        listeEtoiles[2].classList.remove("fa-solid");
                        listeEtoiles[3].classList.remove("fa-solid");

                        listeEtoiles[0].classList.add("fa-solid");
                        listeEtoiles[1].classList.add("fa-regular");
                        listeEtoiles[2].classList.add("fa-regular");
                        listeEtoiles[3].classList.add("fa-regular");
                        console.log(1)
                        break;
                    case listeEtoiles[1]:
                        starSelector = 2

                        listeEtoiles[0].classList.remove("fa-regular");
                        listeEtoiles[1].classList.remove("fa-regular");
                        listeEtoiles[2].classList.remove("fa-solid");
                        listeEtoiles[3].classList.remove("fa-solid");

                        listeEtoiles[0].classList.add("fa-solid");
                        listeEtoiles[1].classList.add("fa-solid");
                        listeEtoiles[2].classList.add("fa-regular");
                        listeEtoiles[3].classList.add("fa-regular");
                        console.log(2)
                        break;
                    case listeEtoiles[2]:
                        starSelector = 3

                        listeEtoiles[0].classList.remove("fa-regular");
                        listeEtoiles[1].classList.remove("fa-regular");
                        listeEtoiles[2].classList.remove("fa-regular");
                        listeEtoiles[3].classList.remove("fa-solid");

                        listeEtoiles[0].classList.add("fa-solid");
                        listeEtoiles[1].classList.add("fa-solid");
                        listeEtoiles[2].classList.add("fa-solid");
                        listeEtoiles[3].classList.add("fa-regular");
                        console.log(3)
                        break;
                    case listeEtoiles[3]:
                        starSelector = 4

                        listeEtoiles[0].classList.remove("fa-regular");
                        listeEtoiles[1].classList.remove("fa-regular");
                        listeEtoiles[2].classList.remove("fa-regular");
                        listeEtoiles[3].classList.remove("fa-regular");

                        listeEtoiles[0].classList.add("fa-solid");
                        listeEtoiles[1].classList.add("fa-solid");
                        listeEtoiles[2].classList.add("fa-solid");
                        listeEtoiles[3].classList.add("fa-solid");
                        console.log(4)
                        break;
                    default:
                        console.log('NON');
                }

                setCookie('LiaisonJsPhp', starSelector, dtExpire, '/');
            });
        };

        let clickPopUpPhoto = document.querySelector("#clickJsFun");
        let popUpPhotoBG = document.querySelector('.backgroundpopup');
        let popUpPhotoBGContainer = document.querySelector('#photoContainer');
        let closeButton = document.querySelector('.closeButton');
        let overflow = document.querySelector('*')

        clickPopUpPhoto.addEventListener('click', (event) => {
            popUpPhotoBG.style.display = "flex";
            popUpPhotoBGContainer.style.display = "flex";
            overflow.style.overflow = "hidden";
        })

        closeButton.addEventListener('click', (event) => {
            popUpPhotoBG.style.display = "none";
            popUpPhotoBGContainer.style.display = "none";
            overflow.style.overflow = "visible";
        })
        document.addEventListener('keydown', function(event) {
            if (event.key === "Escape") {
                popUpPhotoBG.style.display = "none";
                popUpPhotoBGContainer.style.display = "none";
                overflow.style.overflow = "visible";
            }
        });

        popUpPhotoBG.addEventListener('click', (event) => {
            popUpPhotoBG.style.display = "none";
            popUpPhotoBGContainer.style.display = "none";
            overflow.style.overflow = "visible";
        })

        <?php $photosArray = [];
        for ($i = 0; $i < count($lesPhotosUnifier); $i++) {
            array_push($photosArray, $lesPhotosUnifier[$i]['url_photo_produit']);
        }
        ?>

        var photosArray = <?php echo json_encode($photosArray); ?>;
        var arrayAvis = <?php echo json_encode($avisTableau['lesAvis']) ?>;

        for (let m = 0; m < arrayAvis.length; m++) {
            if (arrayAvis[m]['url_photo_produit'] != null)
                photosArray.push(arrayAvis[m]['url_photo_produit'])
        }

        console.log(photosArray);

        let imgCarouselSrc = document.querySelector('#photoAffichee');
        let leftArrow = document.querySelector('#leftArrow');
        let rightArrow = document.querySelector('#rightArrow');

        imgCarouselSrc.src = photosArray[0];
        let position = 0;

        rightArrow.addEventListener('click', (event) => {
            position += 1;
            if (position > photosArray.length - 1) {
                position = 0;
            }
            imgCarouselSrc.src = photosArray[position];
        })

        leftArrow.addEventListener('click', (event) => {
            position -= 1;
            if (position < 0) {
                position = photosArray.length - 1;
            }
            imgCarouselSrc.src = photosArray[position];
        })
    });
</script>

<script>
    let helpCreeCompte = document.querySelector('#interrogationaideConn');
    let helpCreeComptePopup = document.querySelector('#helpCreeCompte')

    helpCreeCompte.addEventListener("mouseover", () => {
        helpCreeComptePopup.classList.add('active')
    })

    helpCreeCompte.addEventListener("mouseout", () => {
        helpCreeComptePopup.classList.remove('active')
    })


    let helpConnCompte = document.querySelector('#interrogationaide');
    let helpConnComptePopup = document.querySelector('#helpConnCompte')

    helpConnCompte.addEventListener("mouseover", () => {
        helpConnComptePopup.classList.add('active')
    })

    helpConnCompte.addEventListener("mouseout", () => {
        helpConnComptePopup.classList.remove('active')
    })
</script>
@endsection
<script src="js/aide.js"></script>

@section('script')



@endsection