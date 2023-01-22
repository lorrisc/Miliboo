@extends('layouts.app')

@section('style')
<link rel="stylesheet" href="/css/accountlog.css">
<link rel="stylesheet" href="/css/infopassword.css">
<link rel="stylesheet" href="/css/popupadress.css">

@endsection

@section('title')
Connexion
@endsection

@section('content')
<section id="pageConnection" class="principalContainer">
    <!-- DISPLAY ERRORS MESSAGE AT REGISTRATION -->
    @if ($errors->any())
    <div class="errorContainer">
        @foreach ($errors -> all() as $error)
        <p>{{ $error }}</p>
        @endforeach

        <button class="closeButton">
            <div></div>
            <div></div>
        </button>
    </div>
    @endif
    @if (session('success'))
    <div class="sucessMessage">
        <p>{{ session('success') }}</p>

        <button class="closeButton">
            <div></div>
            <div></div>
        </button>
    </div>
    @endif
    <h1>Créer un compte ou se connecter </h1>
    <section id="formContainer">
        <!-- CREATE ACCOUNT -->
        <form id="leftCreateAccount">
            <div id="signupbase">
                <div class="accountContainerTitle">
                    <h2>Je suis nouveau client</h2>
                    <p> - Créer un compte </p>


                    <div id="interrogationaideCree">
                        <i class="fa-solid fa-circle-question fa-3x"></i>
                    </div>
                </div>

                <div id="helpCreeCompte">
                    <ul>
                        <li>
                            Renseignez votre adresse mail et confirmez en cliquant sur le bouton « Créer mon compte »
                        </li>
                    </ul>
                </div>

                <input type="email" name="emailsignup" id="emailsignup" placeholder="Votre adresse e-mail" class="largeinput">
                <p class="errormessage">Email non conforme</p>

                <div id="informationAccountSignup">
                    <h3>Créez votre compte pour bénéficier des services suivants :</h3>

                    <p>Suivi de vos commandes</p>
                    <p>Gestion de vos adresses et informations personnelles</p>
                    <p>Abonnement à notre newsletter</p>
                </div>

                <div id="displayPopupNewAccount" class="largebutton">Creer mon compte</div>
            </div>
        </form>

        <!-- LOG IN -->
        <form id="rightLogin" method="POST" action="{{ url('connexionaccount')}}">
            @csrf

            <div class="accountContainerTitle">
                <h2>Je suis déjà client</h2>
                <p> - Se connecter</p>

                <div id="interrogationaideConn">
                        <i class="fa-solid fa-circle-question fa-3x"></i>
                    </div>
                </div>

                <div id="helpConnCompte">
                    <ul>
                        <p id="pBold">Renseignez l’adresse mail à laquelle votre compte est lié, ainsi que votre mot de passe, puis cliquer sur valider<br> <br></p>
                        Renseignez le code que vous avez dû recevoir sur votre smartphone, il permet une connexion plus sécurisée. <br> <br>
                        <p id="rouge">Vous n’avez pas reçu le code de confirmation ?</p>
                        <ul>
                            <li>Vérifiez que votre smartphone n’est pas en mode avion.</li>
                            <li>Il est possible que le numéro de téléphone lié au compte soit erroné. Dans ce cas, contactez le support.</li>
                        </ul>
                    </ul>
                </div>
            </div>

            <input type="email" name="emaillogin" id="emaillogin" placeholder="Votre adresse e-mail" class="largeinput">
            <input type="password" name="passwordlogin" id="passwordlogin" placeholder="Mot de passe" class="largeinput">

            <div id="savelogContainer">
                <input type="checkbox" name="savelog" id="savelog">
                <label for="savelog">Se souvenir de moi</label>
            </div>

            <button id="forgotpasswordbutton">Mot de passe oublié ?</button>

            <button type="submit" class="largebutton">Valider</button>

        </form>
    </section>

    <!-- POPUP FOR CREATE ACCOUNT -->
    <form id="signupPopup" method="POST" action="{{ url('createaccount')}}">
        @csrf
        <div id="signupPopup__top">
            <!-- LEFT PART -->
            <article>

                <h2>Mon compte</h2>

                <input type="email" name="confirmemailsignup" id="confirmemailsignup" placeholder="Adresse email" class="largeinput">

                <div id="signupPopup__password">
                    <input type="password" name="passwordfield" id="passwordfield" placeholder="Mot de passe" class="largeinput">
                    <input type="password" name="passwordfield_confirmation" id="passwordconfirmfield" placeholder="Confirmation du mot de passe" class="largeinput">
                </div>

                <article id="passwordValidationText">
                    <p id="minchar">12 caractères</p>
                    <p id="lowercase">1 minuscule</p>
                    <p id="uppercase">1 majuscule</p>
                    <p id="chiffre">1 chiffre</p>
                    <p id="specialchar">1 caractère spécial</p>
                    <p id="samepass">Confirmation du mot de passe</p>
                </article>

                <article id="signupPopup__Supplement">

                    <article id="supplement__newsletter">
                        <input type="checkbox" name="neslettervalue" id="neslettervalue">
                        <label for="neslettervalue">Je souhaite recevoir la newsletter de miliboo.com (Réductions, Nouveautés, Avant premières...).</label>
                    </article>

                    <article id="supplement__partnernewsletter">
                        <input type="checkbox" name="partnerneslettervalue" id="partnerneslettervalue">
                        <label for="partnerneslettervalue">j'accepte de recevoir la newsletters des partenaires de Miliboo.com</label>
                    </article>

                </article>
            </article>

            <article>

                <h2>Mon adresse de facturation</h2>

                <!-- GENERAL FORM -->
                <article id="leftSignupPopup__generalForm">

                    <div id="generalForm__generalinfo">
                        <select name="civility" id="civility" class="largeinput">
                            <option value="Mr">Mr</option>
                            <option value="Mlle">Mlle</option>
                            <option value="Mme">Mme</option>
                        </select>
                        <input type="text" name="namuser" id="namuser" placeholder="Nom" class="largeinput">
                        <input type="text" name="firstnamuser" id="firstnamuser" placeholder="Prénom" class="largeinput">
                    </div>

                    <!-- <input type="date" name="userbirthday" id="userbirthday" class="largeinput"> -->
                    <input type="text" name="globaladress" id="globaladress" placeholder="Saisir votre adresse complète" class="largeinput fetchaddress">
                    <p class="errormessage" id="addresserror">Adresse introuvable.</p>
                    <div class="normalbutton" id="searchadress">Rechercher votre adresse</div>
                    <input type="text" name="useradress" id="useradress" placeholder="Adresse" class="largeinput unselectinput fetchaddressresult" readonly>

                    <div id="generalForm__infosupaddress">
                        <input type="text" name="postalzip" id="postalzip" placeholder="Code postal" class="largeinput unselectinput fetchopstalzipresult" readonly>
                        <input type="text" name="city" id="city" placeholder="Ville" class="largeinput unselectinput fetchcityresult" readonly>
                        <select name="country" id="country" class="largeinput">
                            <option value="france">France</option>
                            <option value="suisse" disabled>Suisse</option>
                            <option value="allemagne" disabled>Allemagne</option>
                        </select>
                    </div>

                    <div id="generalForm__tel">
                        <div id="generalForm__fax">
                            <label for="tel">Téléphone</label>
                            <input type="text" name="tel" id="tel" placeholder="01 23 45 67 89" class="largeinput">
                        </div>
                        <div id="generalForm__port">
                            <label for="telport">Portable</label>
                            <input type="text" name="telport" id="telport" placeholder="06 12 34 56 78" class="largeinput">
                        </div>
                        
                       
                    </div>
                    <div id="interrogationaideConne">
                            <i class="fa-solid fa-circle-question fa-3x"></i>
                        </div>

                        <div id="helpConnComptee">
                            <p id="rouge">
                                <ul>
                                <li>Saisissez votre adresse complète dans le champ suivant</li>
                                <li>Vous devriez voir une liste d’adresse parmi lesquelles vous pouvez sélectionner la vôtre</li>
                                <li>Si ce n’est pas le cas, cliquez sur « Rechercher votre adresse », si ça ne marche toujours pas, le serveur des adresses est indisponible, réessayez dans quelques minutes.</li>
                                </ul>
                            </p>
                        </div>

                </article>
            </article>
        </div>

        <button type="submit" class="largebutton">Valider mon inscription</button>

    </form>
</section>
@include('partials.popupadress')
@endsection


@section('script')
<script src="js/accountlog.js"></script>
<script src="js/infopassword.js"></script>
<script src="js/adress.js"></script>

<script>
    let helpCreeCompte = document.querySelector('#interrogationaideCree');
    let helpCreeComptePopup = document.querySelector('#helpCreeCompte')

    helpCreeCompte.addEventListener("mouseover", () => {
        helpCreeComptePopup.classList.add('active')
    })

    helpCreeCompte.addEventListener("mouseout", () => {
        helpCreeComptePopup.classList.remove('active')
    })


    let helpConnCompte = document.querySelector('#interrogationaideConn');
    let helpConnComptePopup = document.querySelector('#helpConnCompte')

    helpConnCompte.addEventListener("mouseover", () => {
        helpConnComptePopup.classList.add('active')
    })

    helpConnCompte.addEventListener("mouseout", () => {
        helpConnComptePopup.classList.remove('active')
    })

    let interrogationaideConne = document.querySelector('#interrogationaideConne');
    let helpConnComptee = document.querySelector('#helpConnComptee')

    interrogationaideConne.addEventListener("mouseover", () => {
        helpConnComptee.classList.add('active')
    })

    interrogationaideConne.addEventListener("mouseout", () => {
        helpConnComptee.classList.remove('active')
    })
</script>
@endsection