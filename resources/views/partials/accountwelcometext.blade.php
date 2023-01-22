<h1>Bonjour <span id="pageAccount__password__userfirstname">

        <!-- retrieve first name user -->
        <?php
        if(isset($_COOKIE['account']['account_firstname']))
        {
            $account_firstname = $_COOKIE['account']['account_firstname'];
            echo($account_firstname);
        }
        ?>

    </span> et bienvenue dans votre espace client Miliboo !</h1>