<?php

namespace App\Http\Controllers;

use App\Models\AdresseLivraison;
use App\Models\Civilite;
use Illuminate\Http\Request;

use App\Models\CodePostal;
use App\Models\Commande;
use App\Models\CompteClient;
use App\Models\Personnel;
use App\Models\PhotoProduit;
use App\Models\PivotLignePanier;
use App\Models\Produit;
use App\Models\Ville;

use Exception;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Global_;

class AccountLogController extends Controller
{

    public function index()
    {

        return view('accountlog');
    }

    public function vente()
    {
        return view('directeurVente');
    }


    //************ */ CREATE ACCOUNT
    public function store(Request $request)
    {
        $statusPopup = 1;
        $rules = [
            'confirmemailsignup' => ['required', 'regex:/\b[\w\.-]+@[\w\.-]+\.\w{2,4}\b/'],
            'passwordfield' => ['required', 'string', 'min:12', 'regex:/[a-z]/',  'regex:/[A-Z]/',  'regex:/[0-9]/', 'regex:/[`!@#$%^&*()_+\-=\[\]{};\':"\|,.<>\/?~]/', 'confirmed'],
            'neslettervalue' => ['nullable'],
            'partnerneslettervalue' => ['nullable'],
            'civility' => ['required'],
            'namuser' => ['required'],
            'firstnamuser' => ['required'],
            'useradress' => ['required'],
            'postalzip' => ['required'],
            'city' => ['required'],
            'country' => ['required'],
            'telport' => ['required', 'regex:/[0][1-9](?:[\s]*\d{2}){4}/'],
            'tel' => ['nullable', 'regex:/^[0][1-9](?:[\s]*\d{2}){4}$/'],
            //regex for validate phone. Only : 0X XX XX XX XX || OXXXXXXXXX
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {

            return redirect('connexion')->withInput()->withErrors($validator)->with('statusPopup', $statusPopup);
        } else {
            $data = $request->input();

            // SOME CHARACTERS CAN'T ACCESS DATABASE / CAN ACTIVE COMMANDS ON DATABASE, SO WE HAD TO GENERATE STRINGS USING ONLY KNOWN SECURE STRINGS

            $data['passwordfield'] = '11motdepasseimpossibleaTrouver';

            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $randstring = '';
            for ($i = 0; $i < 32; $i++) {
                $randstring .= $characters[rand(0, strlen($characters) - 1)];
            }

            $salt = '$6$rounds=5000$' . $randstring . '$';
            $encryptedPWD = crypt($data['passwordfield'], $salt);

            dd($encryptedPWD);

            // try {
            if (CompteClient::where('email', '=', $data['confirmemailsignup'])->first()) {
                return redirect('connexion')->withErrors(["Cette adresse email est déjà utilisée."])->with('statusPopup', $statusPopup);
            }


            $compte = new CompteClient();

            $compte->email = $data['confirmemailsignup'];
            $compte->password = $encryptedPWD;
            $compte->nom = $data['namuser'];
            $compte->prenom = $data['firstnamuser'];

            //parse tel space
            $deleteSpaceTel = str_replace(' ', '', $data['tel']);
            $deleteSpaceTelPort = str_replace(' ', '', $data['telport']);
            $compte->tel = $deleteSpaceTel;
            $compte->tel_portable = $deleteSpaceTelPort;

            $compte->newsletter_miliboo = $request->neslettervalue;
            $compte->newsletter_partenaire = $request->partnerneslettervalue;

            // civility
            try {
                $civility = DB::table('civilites')->where('lib_civilite', $request->civility)->select('id')->first();
                $civilityid = $civility->id;
                $compte->civilite_id = $civilityid;
            } catch (Exception $e) {
                return redirect('connexion')->withErrors(["Erreur lors de l'insertion de votre civilitées."])->with('statusPopup', $statusPopup);
            }

            $compte->adresse_client = $data['useradress'];
            // INSERT CITY AND POSTAL ZIP
            try {
                // POSTAL ZIP
                $code_postal = DB::table('code_postals')->where('lib_cp', $request->postalzip)->select('id')->first();
                if ($code_postal == null) {
                    $newcp = new CodePostal();
                    $newcp->pay_id = 1;
                    $newcp->lib_cp = $request->postalzip;
                    $newcp->save();

                    $idcode_postal = DB::table('code_postals')->where('lib_cp', $request->postalzip)->select('id')->first();
                    $idcode_postal = $idcode_postal->id;
                } else {
                    $idcode_postal = $code_postal->id;
                }
                // CITY
                try {
                    $city = DB::table('villes')->where('lib_ville', $request->city)->select('id')->first();
                    if ($city == null) {
                        $ville = new Ville();
                        $ville->code_postal_id = $idcode_postal;
                        $ville->lib_ville = $request->city;
                        $ville->save();

                        $idcity = DB::table('villes')->where('lib_ville', $request->city)->select('id')->first();
                        $idcity = $idcity->id;
                    } else {
                        $idcity = $city->id;
                    }
                } catch (Exception $e) {
                    return redirect('connexion')->withErrors(["Erreur lors de l'insertion de la ville."])->with('statusPopup', $statusPopup);
                }
            } catch (Exception $e) {
                return redirect('connexion')->withErrors(["Erreur lors de l'insertion du code postal."])->with('statusPopup', $statusPopup);
            }

            $compte->ville_id = $idcity;
            $compte->code_postal_id = $idcode_postal;
            $compte->pay_id = 1; //In the SAE only France is valable

            $compte->client_pro = 0;
            $compte->point_fidelite = 0;

            $compte->save();

            $comptebd = CompteClient::where('created_at', '!=', null)->orderBy('created_at', 'desc')->first()->toArray();   

            AdresseLivraison::create(
                array(
                    'ville_id'   =>  $comptebd['ville_id'],
                    'civilite_id'   =>  $comptebd['civilite_id'], 
                    'compte_client_id'   =>  $comptebd['id'], 
                    'pay_id'   =>  $comptebd['pay_id'], 
                    'code_postal_id'   =>  $comptebd['code_postal_id'],
                    'nom_adresse'   =>  'Base adresse_'.$comptebd['id'],  
                    'nom'   =>  $comptebd['nom'], 
                    'prenom'   =>  $comptebd['prenom'], 
                    'adresse_livraison'   =>  $comptebd['adresse_client'],
                    'tel'   =>  $comptebd['tel'], 
                    'indicatif_tel'   =>  $comptebd['indicatif_tel'], 
                    'tel_portable'   =>  $comptebd['tel_portable'], 
                    'indicatif_tel_portable'   =>  $comptebd['indicatif_tel_portable']
                )
            );

            return redirect('connexion')->with('success', "Compte créé avec succès. Veuillez vous connecter.");
        }

        dd('Compte crée !');
        return view('accountlog');
    }



    //************ */ LOG IN ACCOUNT
    public function login(Request $request)
    {
        session()->forget('controller');

        $statusPopup = 0;
        $rules = [
            'emaillogin' => ['required'],
            'passwordlogin' => ['required'],
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect('connexion')->withInput()->withErrors($validator)->with('statusPopup', $statusPopup);
        } else {
            $data = $request->input();


            try 
            {
                $account = CompteClient::where('email', '=', $data['emaillogin'])->first();
                // 1er essai : si pas de compte client, vérifie si existe compte professionnel
                $accountpro = null;

                if ($account == null)
                {
                    $accountpro = Personnel::where('mail', '=', $data['emaillogin'])->first();
                }

                // Essai final, si compte est toujours null, alors pas de professionnel détecté non plus
                if ($account == null && $accountpro == null) {
                    return redirect('/connexion')->withErrors(["Email ou mot de passe incorrect. Veuillez réessayer."])->with('statusPopup', $statusPopup);;
                } 
                else 
                {
                    if ($account != null)
                    {
                        $lib_ville = Ville::select('lib_ville')->where('id', $account->id)->first();
                        $lib_cp = CodePostal::select('lib_cp')->where('id', $account->code_postal_id)->first();

                        $account_id = $account->id;
                        $account_name = $account->nom;
                        $account_firstname = $account->prenom;
                        $account_ville_lib = $lib_ville; //C
                        $account_civilite_id = $account->civilite_id;
                        $account_code_postal_lib = $lib_cp; //C
                        $account_email = $account->email;
                        $account_password = $account->password;
                        $account_adresse_client = $account->adresse_client;
                        $account_tel = $account->tel;
                        $account_tel_portable = $account->tel_portable;

                        session()->put('telport', $account_tel_portable);

                        if (hash_equals($account_password, crypt($data['passwordlogin'], $account_password))) {
                        
                            setcookie('account[account_id]', $account_id, time() + 60 * 60 * 24 * 7);

                            // retrive panier
                            try {
                                $command = Commande::where('compte_client_id', '=', $account_id)->where('statut_commande', '=', 'Panier')->first();
                                $panier =  Cart::content();
                                if (isset($account_id)) {
                                    $cartlines = PivotLignePanier::where('commande_id', '=', $command->id)->get()->toArray();
                                    foreach ($cartlines as $key => $cartline) {
                                        $cartlineidentifier = $cartline['produit_id'] . $cartline['couleur_id'];
    
                                        $presentincart = 0;
                                        foreach ($panier as $key => $productt) {
                                            if ($productt->options['productid'] == $cartline['produit_id'] && $productt->options['colorid'] == $cartline['couleur_id']) {
                                                $presentincart = 1;
                                            }
                                        }
                                        if ($presentincart == 0) {
                                            //add db product to cart
                                            //get product data
                                            $productdb = Produit::join('pivot_unifiers', 'pivot_unifiers.produit_id', 'produits.id')
                                                ->where('id', '=', $cartline['produit_id'])
                                                ->where('couleur_id', '=', $cartline['couleur_id'])
                                                ->get(['lib_produit', 'prix', 'promo'])
                                                ->first();
    
                                            $pathimg  = PhotoProduit::where('produit_id', '=', $cartline['produit_id'])->where('couleur_id', '=',  $cartline['couleur_id'])->get()->first();
                                            //insert in basket
                                            Cart::add([
                                                'id' => $cartlineidentifier,
                                                'name' => $productdb['lib_produit'],
                                                'qty' => $cartline['qte'],
                                                'price' => $productdb['prix'] * $productdb['promo'],
                                                'weight' => 0,
                                                'options' => [
                                                    'productid' => $cartline['produit_id'],
                                                    'colorid' => $cartline['couleur_id'],
                                                    'pathimg' => $pathimg['url_photo_produit'],
                                                    'promo' => $productdb['promo'],
                                                    'initialprice' => $productdb['prix']
                                                ]
                                            ]);
                                        }
                                    }
                                }
                            } catch (Exception $e) {
                                $a=1;
                            }
                            return redirect('/smsConfirm')->with('success', "Validation à double facteur, entrez le code reçu.");
                        }
                        else 
                        {
                            return redirect('/connexion')->withErrors(["Email ou mot de passe incorrect. Veuillez réessayer."])->with('statusPopup', $statusPopup);
                        }
                    }

                    else if ($accountpro != null)
                    {
                        $accountpro_id = $accountpro->id;
                        $accountpro_login = $accountpro->login;
                        $accountpro_name = $accountpro->nom;
                        $accountpro_firstname = $accountpro->prenom;
                        $accountpro_mail = $accountpro->mail;
                        $accountpro_password = $accountpro->password;

                        if ($accountpro_password = $data['passwordlogin']) {
                            echo "Mot de passe correct !";
                            return redirect('/')->with('success', "Connexion réussi.");
                        }
                        else 
                        {
                            return redirect('/connexion')->withErrors(["Email ou mot de passe incorrect. Veuillez réessayer."])->with('statusPopup', $statusPopup);
                        }
                        return redirect('/')->with('success', "Connexion réussi.");
                    }

                    else {
                        return redirect('/connexion')->withErrors(["Email ou mot de passe incorrect. Veuillez réessayer."])->with('statusPopup', $statusPopup);
                    }
                }
            } catch (Exception $e) {
                dd(1);
                return redirect('/connexion')->withErrors(["Email ou mot de passe incorrect. Veuillez réessayer."])->with('statusPopup', $statusPopup);
            }
        }
    }
}

