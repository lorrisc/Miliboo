<!-- LEFT MENU ON ACCOUNT PAGE -->

<section id="pageAccount__menu">

    <article id="pageAccount__menu__commands" class="accountmenucat">

        <h2>Mes commandes</h2>

        <?php
            use Illuminate\Support\Facades\Session;

            if($_COOKIE['accountpro']['accountpro_id'] != null) { 
                if ($_COOKIE['accountpro']['accountpro_id'] == 1)
                {
                    echo('<div class="accountmenucat__container">');
                    echo('<a href="/ventesparmois">Consulter les ventes</a>');
                    echo('</div>');
                }

                else if ($_COOKIE['accountpro']['accountpro_id'] == 2)
                {
                    echo('<div class="accountmenucat__container">');
                    echo('<a href="/detailproduits">Consulter le détail des produits</a>');
                    echo('<a href="/nouvelleboutique">Ajouter boutiques</a>');
                    echo('</div>');
                }

                else if ($_COOKIE['accountpro']['accountpro_id'] == 3)
                {
                    echo('<div class="accountmenucat__container">');
                    echo('<a href="/consultations">Consulter les commandes</a>');
                    echo('</div>');
                }

                else if ($_COOKIE['accountpro']['accountpro_id'] == 6)
                {
                    echo('<div class="accountmenucat__container">');
                    echo('<a href="/anonymisation">Anonymiser les données</a>');
                    echo('</div>');
                }
            }
        ?>
    </article>

    <article id="pageAccount__menu__logout" class="accountmenucat">
        <div class="accountmenucat__container">
            <a href="/logout">Se déconnecter</a>
        </div>
    </article>

</section>
