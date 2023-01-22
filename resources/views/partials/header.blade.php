<header>
    <p id="topinfo">Livraison gratuite & expédition en 24h</p>

    <section id="top">

        <section id="top__left">
            <a href="/" id="title">
                <img src="/assets/logo.svg" alt="logo Miliboo">
            </a>

            <form method="POST" action="{{ url('/recherche')}}">
                @csrf
                <input type="search" name="searchBar" id="searchBar" placeholder="Je recherche...">
            </form>

        </section>

        <section id="top__right">

            <a href="{{ route('besoin-aide') }}">
                <img src="/assets/icons/help.svg" alt="help icon">

                <div id="help__info" class="top__righticon__informations">
                    <div class="triangle"></div>
                    <p>Aide & Contact</p>
                </div>
            </a>

            <!-- If user is connect dont display the login page on account button -->
            @if(isset($_COOKIE["account"]["account_id"]))
            <a href="{{ route('compte')}}">
                @elseif(isset($_COOKIE["accountpro"]["accountpro_id"]))
                <a href="{{ route('comptepro')}}">
                    @else
                    <a href="{{ route('connexion')}}">
                        @endif
                        <img src="/assets/icons/account.svg" alt="account icon">

                        <div id="account__info" class="top__righticon__informations">
                            <div class="triangle"></div>
                            <p>Mon compte</p>
                        </div>
                    </a>

                    <a href="{{route('monpanier')}}">
                        <img src="/assets/icons/basket.svg" alt="basket icon">

                        <div id="basket__info" class="top__righticon__informations">
                            <div class="triangle"></div>
                            <p>Votre panier</p>
                        </div>
                    </a>

                    <?php

                    // use App\Models\Commande;
                    // use App\Models\PhotoProduit;
                    // use App\Models\PivotLignePanier;
                    // use App\Models\Produit;
                    use Gloudemans\Shoppingcart\Facades\Cart;
                    use Illuminate\Support\Facades\Session;


                    $panier =  Cart::content();
                    if (count($panier) > 0) {
                        echo "<article id=\"marketnumber\">";
                        echo (count($panier));
                        echo "</article>";
                    }


                    ?>
        </section>

    </section>

    <nav id="generalNavBar">

        <section id="left">
            <a href="" id="product" class="active">Nos produits</a>
            <a href="{{ route('nouveautes')}}" id="news">Nouveautés</a>
            <a href="{{ route('promotion')}}" id="promotions">Promotions</a>
            <a href="{{ route('madeinfrance')}}" id="frenchProduct" class="blue">Made in France</a>
        </section>

        <section id="right">
            @if(isset($_COOKIE["account"]["account_id"]))
            <a href="{{ route('likes')}}">Mes favoris</a>
            @else
            <a href="{{ route('likesnotconnected')}}">Mes favoris</a>
            @endif
            <a href="http://blog.miliboo.com/" target="_blank" rel="noopener noreferrer">Le blog</a>
            <a href="{{ route('boutique_miliboo')}}">Nos boutiques</a>
            <?php
            if (isset($_COOKIE['accountpro']['accountpro_id'])) {
                echo ("<a href='/comptepro'>Espace pro</a>");
            }
            ?>
        </section>

    </nav>

    <nav id="navCat">

        <section id="navCat__top">
            <?php

            use Illuminate\Support\Facades\DB;

            $lescategories = DB::table('categories')->orderBy('id')->get()->toArray();
            global $lescategoriesmere;
            $lescategoriesmere = [];
            foreach ($lescategories as $cat) {
                $catarray = (array)$cat;
                if ($catarray['categorie_id'] == NULL) {
                    echo '<button>' . $catarray['lib_categorie'] . '</button>';
                    array_push($lescategoriesmere, [$catarray['id'], $catarray['photo_path']]);
                }
            }
            ?>
        </section>

        <?php
        echo '<section id="navCat__hiddenCats">';
        $rangid = 0;
        $lescategoriesmoyennes = DB::table('categories')->whereNotNull('categorie_id')->orderBy('id')->get()->toArray();
        foreach ($lescategoriesmere as $cat) {
            echo '<article class="navCat__hiddenCat__Category">';
            echo '<div class="enumCategory">';

            foreach ($lescategoriesmoyennes as $catmoyenne) {
                $catarraymoyenne = (array)$catmoyenne;
                if ($catarraymoyenne['categorie_id'] == $lescategoriesmere[$rangid][0]) {
                    echo '<a href="/categorie/' . $catarraymoyenne['id'] . '" class="categoryTitle" id="fauteilbureau">' . $catarraymoyenne['lib_categorie'] . '</a>';
                    $lacategoriemoyenneactuelle = $catarraymoyenne['id'];
                    foreach ($lescategoriesmoyennes as $catpetite) {
                        $catarraypetite = (array)$catpetite;
                        if ($catarraypetite['categorie_id'] == $lacategoriemoyenneactuelle) {
                            echo '<a href="/categorie/' . $catarraypetite['id'] . '">' . $catarraypetite['lib_categorie'] . '</a>';
                        }
                    }
                }
            }
            echo '</div>';

            echo '<div class="images">';

            echo '<img src="/assets/imageCategoryDB/' . $lescategoriesmere[$rangid][1] . '" alt="Image de présentation de la catégorie">';
            echo '</div>';
            echo '</article>';
            $rangid += 1;
        }
        echo '</section>';
        ?>
    </nav>
</header>