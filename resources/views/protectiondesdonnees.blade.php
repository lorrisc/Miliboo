@extends('layouts.app')

@section('style')
<link rel="stylesheet" href="/css/result.css">
<link rel="stylesheet" href="/css/color.css">
<link rel="stylesheet" href="/css/protectiondesdonnees.css">
@endsection

@section('title')
Pretection des données
@endsection

@section('content')

<section class="protec" id="lasection">
    <h1>Politique de protection des données personnelles</h1>
    <section class="protec" id="titres">
        <ul>
            <a href="#preambule">
                <li>1.Préambule</li>
            </a>
            <a href="#donnee">
                <li>2.Les données à caractère personnel traitées par Miliboo</li>
            </a>
            <a href="#sensibles">
                <li>3.Les données sensibles personnel traitées par Miliboo</li>
            </a>
            <a href="#personnes">
                <li>4.Les personnes concernées par la collecte et le traitement des données</li>
            </a>
            <a href="#finalites">
                <li>5.Les finalités des traitements des données</li>
            </a>
            <a href="#destinataires">
                <li>6.Les destinataires de vos données à caractère personnel</li>
            </a>
            <a href="#dureeconservation">
                <li>7.Les durées de conservation de vos données</li>
            </a>
            <a href="#transferts">
                <li>8.Les transferts de données personnelles en dehors de l'Union européenne</li>
            </a>
            <a href="#securite">
                <li>9.La sécurité de vos données personnelles</li>
            </a>
            <a href="#droits">
                <li>10.Vos droits concernant l’utilisation de vos données</li>
            </a>
        </ul>
    </section>

    <section class="protec" id="preambule">
        <div>
            <h2>1.Préambule</h2>

            <p>
                Dans le cadre de votre navigation et de votre utilisation des services du site de Miliboo, il vous sera parfois nécessaire de communiquer des données à caractère personnelle à Miliboo <br>
                Nous portons une attention toute particulière à la protection de votre vie privée et de vos données en général. <br><br>
                Nous nous engageons à traiter ces données, conformément aux dispositions des lois suivantes : <br>
            <ul>
                <li>La loi « Informatique et Libertés » du 6 janvier 1978</li>
                <li>Le Règlement Européen 2016/679 du 27 Avril 2016 pour la protection des données personnelles (RGPD)</li>
            </ul>
            Nous utilisons comme unique type de témoins de navigation les cookies. <br>

            Les données à caractère personnelles traités à votre égard par le site Miliboo sont subdivisibles en catégories de cookies suivantes : <br> <br>

            <ul>
                <li>Les cookies strictement nécessaires</li>
                <li>Les cookies de performance</li>
                <li>Les cookies de personnalisation du site</li>
            </ul>

            Pour en savoir plus sur l’utilisation des cookies, vous pouvez vous rendre sur notre politique d’utilisation des cookies
            </p>
        </div>
    </section>

    <section class="protec" id="donnee">
        <div>
            <h2>2.Les données à caractère personnel traitées par Miliboo</h2>

            <p>
                Oui, Miliboo traite des données à caractère personnel afin de vous offrir la possibilité d’avoir un compet et un panier fonctionnel, <br>
                et, si vous le souhaitez uniquement, afin d’optimiser et de personnaliser votre navigation sur le site.

            <div class="gras">
                Quels catégories traitent des données à caractère personnel ? <br> <br>
                Données d’identification
            </div>

            Nous collectons votre civilité, nom, prénom, date de naissance, type de compte. <br> <br>
            Pour que vous puissiez créer un compte personnel, pour nous permettre de situer de manière géographique notre clientèle à des fins <br>
            d’amélioration du service Miliboo. <br> <br>

            Des données à caractère personnel sont-elles traitées ?
            <div>
                <input type="radio" checked>
                <label for="scales">Oui</label> &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp

                <input type="radio" disabled>
                <label for="horns">Non</label>
            </div> <br>

            Données à caractère personnel : nom, prénom, numéro de téléphone. <br> <br> <br> <br>

            <div class="gras">
                Coordonnées
            </div>
            Nous collectons l’adresse email et postale (de livraison et de facturation), numéro de téléphone fixe et portable <br> <br>

            Des données à caractère personnel sont-elles traitées ?
            <div>
                <input type="radio" checked>
                <label for="scales">Oui</label> &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp

                <input type="radio" disabled>
                <label for="horns">Non</label>
            </div> <br>

            Données à caractère personnel : Adresse email et postale (de livraison et de facturation), numéro de téléphone fixe et portable <br> <br> <br> <br>

            <div class="gras">
                Données d’authentification
            </div>
            Nous collectons votre login et votre mot de passe (crypté) <br> <br>

            Des données à caractère personnel sont-elles traitées ?
            <div>
                <input type="radio" checked>
                <label for="scales">Oui</label> &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp

                <input type="radio" disabled>
                <label for="horns">Non</label>
            </div> <br>

            Données à caractère personnel : mail, login, mot de passe crypté. <br> <br> <br> <br>

            <div class="gras">
                Données Commande
            </div>
            Nous collectons l’id, le montant de la commande, la date et l’heure de la commande, l’adresse, l’adresse de facturation et le mode de livraison, <br>
            le nombre de points de fidélité. <br>
            Pour que nous puissions établir un historique des commandes, la gestion de notre comptabilité et de vos points de fidélité. <br> <br>

            Des données à caractère personnel sont-elles traitées ?
            <div>
                <input type="radio" checked>
                <label for="scales">Oui</label> &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp

                <input type="radio" disabled>
                <label for="horns">Non</label>
            </div> <br>

            Données à caractère personnel : <br>
            <ul>
                <li>nom, prénom, numéro de téléphone, adresse, adresse de facturation</li>
                <li>numéro de carte bancaire, la date d’expiration seulement</li>
            </ul> <br> <br> <br>

            <div class="gras">
                Données Bancaires
            </div>
            Nous collectons le numéro de carte bancaire, et la date d’expiration à des fins d’exécution de paiement et de mémorisation de la carte bancaire/compte PayPal <br>
            uniquement si le client y a consenti pour que vous puissiez régler le montant de votre commande le plus facilement possible. <br> <br>

            Des données à caractère personnel sont-elles traitées ?
            <div>
                <input type="radio" checked>
                <label for="scales">Oui</label> &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp

                <input type="radio" disabled>
                <label for="horns">Non</label>
            </div> <br>

            Données à caractère personnel : <br>
            <ul>
                <li>nom, prénom</li>
                <li>- numéro de carte bancaire, date d’expiration seulement</li>
            </ul> <br> <br> <br>

            <div class="gras">
                Données Produits
            </div>
            Nous collectons les informations relatives aux produits consultés par le client, les produits qu’il met en favoris ou ceux qu’il like et pour finir, <br>
            les avis qu’il laisse sur les produits. <br> <br>

            Des données à caractère personnel sont-elles traitées ?
            <div>
                <input type="radio" disabled>
                <label for="scales">Oui</label> &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp

                <input type="radio" checked>
                <label for="horns">Non</label>
            </div> <br> <br> <br>

            <div class="gras">
                Données relatives à vos préférences
            </div>
            Nous collections l’id de votre compte <br> <br>

            Des données à caractère personnel sont-elles traitées ?
            <div>
                <input type="radio" disabled>
                <label for="scales">Oui</label> &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp

                <input type="radio" checked>
                <label for="horns">Non</label>
            </div> <br> <br> <br>

            <div class="gras">
                Données relatives à votre fidélité
            </div>
            Nous collections les points de fidélité de votre compte <br> <br>

            Des données à caractère personnel sont-elles traitées ?
            <div>
                <input type="radio" disabled>
                <label for="scales">Oui</label> &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp

                <input type="radio" checked>
                <label for="horns">Non</label>
            </div> <br> <br>
            </p>
    </section>

    <section class="protec" id="sensibles">
        <div>
            <h2>3.Les données sensibles personnel traitées par Miliboo</h2>

            Nous ne collectons pas de données « sensibles » ou personnelles (données relatives à la santé, préférences sexuelles, opinions politiques, croyances religieuses ...). <br> <br>

            Nous supposons et vous agréez, qu’Il est de votre responsabilité de veiller à ce que vos enfant ou mineurs quelconque sous votre surveillance ne puisse effectuer des achats <br>
            sur notre site et lorsque le traitement des données requiert un consentement, à ce qu’ils donnent eux-mêmes ou non le consentement
            <p>
            </p>
        </div>
    </section>

    <section class="protec" id="personnes">
        <div>
            <h2>4.Les personnes concernées par la collecte et le traitement des données</h2>

            <p>
                Seuls les clients de Miliboo qui possèdent un compte sont susceptibles de voir leurs données traitées par Miliboo, conformément au Règlement Général de Protection des Données. <br> <br>

                Des données supplémentaires sont traitées si les actions suivantes occurrent :
            <ul>
                <li>Un client s’abonne à la newsletter Miliboo</li>
                <li>Un client réalise une commande en ligne, ou modifie son panier</li>
            </ul>
            </p>
        </div>
    </section>

    <section class="protec" id="finalites">
        <div>
            <h2>5.Les finalités des traitements des données</h2>

            <p>
                Les données à caractère personnelles collectées sont traitées uniquement pour les finalités ci-dessous : <br>

            <table>
                <thead>
                    <th>Finalité de traitement</th>
                    <th>Utilisation</th>
                    <th>Fondement juridiques</th>
                </thead>

                <tbody>
                    <tr>
                        <td class="gras">Création et modification du compte</td>
                        <td class="left">
                            <ul>
                                <li>Création et modification des informations relative au compte</li>
                                <li>Authentification et connexion au compte</li>
                            </ul>
                        </td>
                        <td>Conformément aux conditions générales de ventes</td>
                    </tr>

                    <tr>
                        <td class="gras">Gestion des commandes</td>
                        <td class="left">
                            <ul>
                                <li>Permission aux professionnels de traiter les commandes</li>
                                <li>Utilisation des coordonnées transmises au livreurs afin de vous livrer</li>
                            </ul>
                        </td>
                        <td>Conformément aux conditions générales de ventes, si vous êtes clients et avez choisi de recevoir les newsletters </td>
                    </tr>

                    <tr>
                        <td class="gras">Envoi de newsletters qui pourrait vous intéresser</td>
                        <td class="left">
                            <ul>
                                <li>Permission d’envoyer des newsletters à votre adresse mail</li>
                            </ul>
                        </td>
                        <td>Conformément aux conditions générales de ventes et si vous êtes clients</td>
                    </tr>

                    <tr>
                        <td class="gras">Gestion des points de fidélité</td>
                        <td class="left">
                            <ul>
                                <li>Permet d’obtenir des promotions et remises sur les produits grâce a vos points de fidélité</li>
                            </ul>
                        </td>
                        <td>Conformément aux conditions générales de ventes</td>
                    </tr>

                    <tr>
                        <td class="gras">Gestion de la facturation</td>
                        <td class="left">
                            <ul>
                                <li>Permet de finaliser les factures et les paiements de manière sécurisée</li>
                            </ul>
                        </td>
                        <td>Conformément aux conditions générales de ventes</td>
                    </tr>
                </tbody>
            </table>
            </p>
        </div>
    </section>

    <section class="protec" id="destinataires">
        <div>
            <h2>6.Les destinataires de vos données à caractère personnel</h2>

            <table id="grande2">
                <thead>
                    <th>Destinataires</th>
                    <th>Finalités</th>
                    <th>Coordonnées</th>
                </thead>

                <tbody>
                    <tr>
                        <td class="gras">Le personnel de Miliboo</td>
                        <td class="left">
                            <ul>
                                <li>Connexion, modification du compte</li>
                                <li>Traitement des commandes</li>
                                <li>Traitement du panier </li>
                            </ul>
                        </td>
                    </tr>

                    <tr>
                        <td class="gras">Le directeur du service vente</td>
                        <td class="left">
                            <ul>
                                <li>Finalisation de la commande</li>
                                <li>Etude des bénéfices affectués par la vente de biens</li>
                            </ul>
                        </td>
                    </tr>

                    <tr>
                        <td class="gras">Personnel des services de paiement en ligne</td>
                        <td class="left">
                            <ul>
                                <li>Acceptation et finalisation du paiement</li>
                                <li>Mémorisation des informations de paiements</li>
                            </ul>
                        </td>
                    </tr>

                    <tr>
                        <td class="gras">Services chargés de l’expédition des produits</td>
                        <td class="left">
                            <ul>
                                <li>Finalisation de la livraison</li>
                            </ul>
                        </td>
                    </tr>

                    <tr>
                        <td class="gras">Services chargés de la gestion des commandes</td>
                        <td class="left">
                            <ul>
                                <li>Finalisation de la commande</li>
                            </ul>
                        </td>
                    </tr>

                    <tr>
                        <td class="gras">Le délégué chargé de la protection des données</td>
                        <td class="left">
                            <ul>
                                <li>Vérification du respect du RGPD concernant l’utilisation de vos données</li>
                            </ul>
                        </td>
                        <td>
                            Mail : <a href="mailto:pascal.pro@miliboo.com" id="mail">pascal.pro@miliboo.com</a> <br>
                            Tel : <a href="tel:+330678897128" id="mail">06.78.89.71.28</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    <section class="protec" id="dureeconservation">
        <div>
            <h2>7.Les durées de conservation de vos données</h2>

            <p>
            <div class="gras">Données et informations relatives au compte :</div> <br>
            Les données sont stockées jusqu' à la suppression du compte s’il y a. <br> <br>
            Dans le cas contraire : <br>

            <ul>
                <li>Si l’utilisateur est un prospect, c’est-à-dire qu’il n’a jamais passé de commandes depuis la création de son compte, <br>
                    alors les données relatives au compte sont supprimées au bout de 12 mois après la dernière connexion de l’utilisateur.</li> <br>
                <li>Si le compte a déjà passé au moins une commande, alors les données relatives au compte sont supprimées au bout de <br>
                    36 mois après la dernière connexion de l’utilisateur.</li>
            </ul> <br> <br>

            <div class="gras">Données et informations relatives aux commandes :</div> <br>

            Les données relatives aux commandes sont conservées pendant deux semaines après l’envoi de la commande, afin de pouvoir récupérer <br>
            ces données s’il y a un problème lors du traitement de la commande. <br> <br>
            Lorsque l’utilisateur valide la réception totale de sa commande, les données sont conservées pendant 5 ans, et sont archivées pendant 3 ans <br> <br> <br> <br>

            <div class="gras">Données et informations relatives à vos points de fidélité</div> <br>

            Les mesures appliquées quant à la durée de conservation des données et informations relatives à vos points de fidélité correspondent <br>
            à celles relatives au compte, c’est-à-dire : <br> <br>
            Les données sont stockées jusqu' à la suppression du compte s’il y a. <br> <br>

            Dans le cas contraire : <br> <br>
            <div class="left">
                <ul>
                    <li>Dans l’hypothèse que le compte n’est pas un prospect s’il comporte des points de fidélités (car cela signifie que des commandes ont été <br>
                        passées), alors les données relatives au compte sont supprimées au bout de 36 mois après la dernière connexion de l’utilisateur.</li>
                </ul>
            </div>
            </p>
        </div>
    </section>

    <section class="protec" id="transferts">
        <div>
            <h2>8.Les transferts de données personnelles en dehors de l'Union européenne</h2>

            <p>
                Aucune données ne sont transférées en dehors de l’Union européenne
            </p>
        </div>
    </section>

    <section class="protec" id="securite">
        <div>
            <h2>9.La sécurité de vos données personnelles</h2>

            <p>
                Conformément aux lois RGPD, Nous avons développé dès la conception une démarche <strong>Privacy by Design et Privacy by default</strong>. Nous considérons donc la protection <br>
                de vos données personnelles lors du développement, de la conception, de la sélection et de l'utilisation de nos services basés sur le <br>
                traitement des données personnelles. <br> <br>

            <div class="gras">Les principales mesures de sécurités entreprises par MILIBOO sont : </div> <br>

            Le contrôle d’accès des utilisateurs : <br> <br>

            Le processus de contrôle d'accès se déroule en trois étapes : <strong>l'authentification</strong> de l'utilisateur via ses identifiants : son email et son mot de passe, le <strong>contrôle</strong> <br>
            des <strong>autorisations</strong> qui lui sont attribuées (client, membre du service professionnel Miliboo) puis la <strong>validation</strong> ou non de l'accès, si ses identifiants sont corrects. <br> <br>

            De plus, le mot de passe doit être complexe et conformes aux exigences des autorités compétentes: <br> <br>

            Le mot de passe doit répondre à toutes ces contraintes : <br>

            <ul>
                <li>Au moins 12 caractères</li>
                <li>Au moins une majuscule, un chiffre et un caractère spécial</li>
            </ul> <br>

            Le chiffrement des données : <br> <br>
            Miliboo chiffre les données <strong>sensibles</strong> de <strong>connexions</strong> tels que les mots de passe. Le chiffrement utiliser est <strong>AES-256 et AES-128</strong>. Les données client peuvent demander <br>
            à être anonymiser. Seul le délégué à la protection des données peux les anonymiser. <br> <br>


            Notez également que chaque titulaire de compte est responsable de la confidentialité de ce mot de passe. Nous vous recommandons de ne pas le <br>
            partager avec des tiers. Nous ne vous enverrons jamais d'e-mail vous demandant votre identifiant, votre mot de passe ou vos coordonnées bancaires.
            </p>
        </div>
    </section>

    <section class="protec" id="droits">
        <div>
            <h2>10.Vos droits concernant l’utilisation de vos données</h2>

            <p>
                Conformément aux obligations du RGPD, vous disposez des droits suivants : <br> <br>

            <ul>
                <li>Droit à l’information : vous pouvez demander la rectification, la mise à jour, la suppression. <br>
                    Vous pouvez demander que nous arrêtions d'utiliser vos données personnelles</li> <br>
                <li>Droit d’accès : vous pouvez demander l'accès à vos données personnelles détenues par Miliboo ainsi qu’une copie, y compris sous forme électronique.</li> <br>
                <li>Droit d’opposition : vous pouvez vous opposer aux traitement de vos données, Vous pouvez également décider de rectifier vos données si celles-ci sont erronées</li> <br>
                <li>Droit à l’oubli : vous pouvez retirer votre consentement sans affecter la licéité du traitement précédemment effectué</li> <br>
                <li>Droit à la limitation : vous pouvez demander la limitation du traitement de vos données personnelles</li> <br>
                <li>Droit à la portabilité des données : vous pouvez demander la portabilité de vos données personnelles.</li> <br>
                <li>Droit de dernières volontés : vous pouvez transmettre à Miliboo des "dernières volontés" concernant vos informations personnelles <br>
                    en cas de décès (par exemple, les supprimer ou les transférer à la personne de votre choix).</li>
            </ul>
            </p>
        </div>
    </section>
</section>
@endsection