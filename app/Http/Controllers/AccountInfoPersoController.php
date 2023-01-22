<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Exception;
use App\Models\Ville;
use App\Models\AdresseLivraison;
use App\Models\Avis;
use App\Models\CompteClient;
use App\Models\CodePostal;
use Illuminate\Support\Facades\Session;




class AccountInfoPersoController extends Controller
{
    public function index()
    {
        $account_id = $_COOKIE['account']['account_id'];
        // retrieve deliveries
        $deliveries = [];
        if ($deliveriesGet = AdresseLivraison::where('compte_client_id', '=', $account_id)->first() == null) {
            return view('accountinfoperso')->with('deliveries', $deliveries);
        } else {
            $deliveriesGet = AdresseLivraison::where('compte_client_id', '=', $account_id)->get()->toArray();
            // dd($deliveriesGet);
            foreach ($deliveriesGet as $delivery) {
                //dd($delivery['id']);
                $city = DB::table('villes')->where('id', $delivery['ville_id'])->first();
                $lib_ville = $city->lib_ville;

                $postal_zip = DB::table('code_postals')->where('id', $delivery['code_postal_id'])->first();
                $lib_postal_zip = $postal_zip->lib_cp;

                $civilite_id = DB::table('civilites')->where('id', $delivery['civilite_id'])->first();
                $civilite_lib = $civilite_id->lib_civilite;

                $newdelivery = array(
                    'id' => $delivery['id'],
                    'nom_adresse' => $delivery['nom_adresse'],
                    'nom' => $delivery['nom'],
                    'prenom' => $delivery['prenom'],
                    'civilite_lib' => $civilite_lib,

                    'tel' => $delivery['tel'],
                    'tel_portable' => $delivery['tel_portable'],

                    'adresse_livraison' => $delivery['adresse_livraison'],
                    'ville_lib' => $lib_ville,
                    'code_postal_lib' => $lib_postal_zip,
                    'pay_id' => 1,
                );

                array_push($deliveries, $newdelivery);
            }
        }
        return view('accountinfoperso')->with('deliveries', $deliveries);
    }
    public function consultaccountinfo()
    {
        $account_id = $_COOKIE['account']['account_id'];
        $accountInfo = CompteClient::where('compte_clients.id', '=', $account_id)
            ->join('villes', 'compte_clients.ville_id', '=', 'villes.id')
            ->join('code_postals', 'compte_clients.code_postal_id', '=', 'code_postals.id')
            ->join('pays', 'compte_clients.pay_id', '=', 'pays.id')
            ->join('civilites', 'compte_clients.civilite_id', '=', 'civilites.id')
            ->get(['email', 'nom', 'prenom', 'adresse_client', 'tel', 'tel_portable', 'lib_ville', 'lib_cp', 'lib_pays', 'lib_civilite'])
            ->first()->toArray();


        $addressesInfo = AdresseLivraison::where('compte_client_id', '=', $account_id)
            ->join('villes', 'adresse_livraisons.ville_id', '=', 'villes.id')
            ->join('code_postals', 'adresse_livraisons.code_postal_id', '=', 'code_postals.id')
            ->join('pays', 'adresse_livraisons.pay_id', '=', 'pays.id')
            ->join('civilites', 'adresse_livraisons.civilite_id', '=', 'civilites.id')
            ->get(['adresse_livraisons.id', 'nom_adresse', 'adresse_livraison', 'lib_ville', 'lib_cp', 'lib_pays', 'nom', 'prenom', 'lib_civilite', 'tel', 'tel_portable'])
            ->toArray();

        $avisInfo = Avis::where('compte_client_id', '=', $account_id)
            ->join('produits', 'avis.produit_id', '=', 'produits.id')
            ->join('note_avis', 'avis.note_avis_id', '=', 'note_avis.id')
            ->get(['titre_avis', 'detail_avis', 'date_avis', 'lib_produit', 'note_avis'])
            ->toArray();

        return view('accountconsultinfo')->with('accountInfo', $accountInfo)->with('addressesInfo', $addressesInfo)->with('avisInfo', $avisInfo);
    }

    public function editaccount(Request $request)
    {
        $rules = [
            'edit__email' => ['required', 'regex:/\b[\w\.-]+@[\w\.-]+\.\w{2,4}\b/'],
            'edit__name' => ['required'],
            'edit__firstname' => ['required'],
            'edit__telport' => ['required'],
            'edit__civility' => ['required'],

            'useradress' => ['required'],
            'postalzip' => ['required'],
            'city' => ['required'],

            'edit__country' => ['required'],

            'edit__telport' => ['required', 'regex:/[0][1-9](?:[\s]*\d{2}){4}/'],
            'edit__tel' => ['nullable', 'regex:/^[0][1-9](?:[\s]*\d{2}){4}$/'],

        ];
        $validator = Validator::make($request->all(), $rules);

        $user_id = $_COOKIE['account']['account_id'];

        if ($validator->fails()) {
            return redirect('/compte_information_personnelles')->withInput()->withErrors($validator);
        } else {
            $data = $request->input();
            if (CompteClient::where('email', '=', $data['edit__email'])->where('id', '!=', $user_id)->first()) {
                return redirect('/compte_information_personnelles')->withErrors(["Cette adresse email est déjà utilisée."]);
            }

            // civility
            try {
                $civility = DB::table('civilites')->where('lib_civilite', $request->edit__civility)->select('id')->first();
                $civilityid = $civility->id;
            } catch (Exception $e) {
                return redirect('/compte_information_personnelles')->withErrors(["Erreur lors de l'insertion de votre civilitées."]);
            }

            try {
                // POSTAL ZIP
                $code_postal = DB::table('code_postals')->where('lib_cp', $request->postalzip)->select('id')->first();
                if ($code_postal == null) {
                    $newcp = new CodePostal();
                    $newcp->pay_id = 1;
                    $newcp->lib_cp = $request->postalzip;
                    $newcp->save();

                    $idcode_postal = DB::table('code_postals')->where('lib_cp', $request->postalzip)->select('id', 'lib_cp')->first();
                } else {
                    $idcode_postal = DB::table('code_postals')->where('lib_cp', $request->postalzip)->select('id', 'lib_cp')->first();
                }
                // CITY
                try {
                    $city = DB::table('villes')->where('lib_ville', $request->city)->select('id')->first();
                    if ($city == null) {
                        $ville = new Ville();
                        $ville->code_postal_id = $idcode_postal->id;
                        $ville->lib_ville = $request->city;
                        $ville->save();
                        $idcity = DB::table('villes')->where('lib_ville', $request->city)->select('id', 'lib_ville')->first();
                    } else {
                        $idcity = DB::table('villes')->where('lib_ville', $request->city)->select('id', 'lib_ville')->first();
                    }
                } catch (Exception $e) {
                    return redirect('/compte_information_personnelles')->withErrors(["Erreur lors de l'insertion de la ville."]);
                }
            } catch (Exception $e) {
                return redirect('/compte_information_personnelles')->withErrors(["Erreur lors de l'insertion du code postal."]);
            }



            $deleteSpaceTel = str_replace(' ', '', $data['edit__tel']);
            $deleteSpaceTelPort = str_replace(' ', '', $data['edit__telport']);
            //global insert
            DB::table('compte_clients')->where('id', $user_id)->update([
                'email' => $data['edit__email'],
                'nom' => $data['edit__name'],
                'prenom' => $data['edit__firstname'],
                'adresse_client' => $data['useradress'],
                'tel_portable' => $deleteSpaceTelPort,
                'tel' => $deleteSpaceTel,
                'civilite_id' => $civilityid,
                'ville_id' => $idcity->id,
                'code_postal_id' => $idcode_postal->id,
            ]);

            $lib_civilite = DB::table('civilites')->where('id', $civilityid)->select('lib_civilite')->first();
        }
        return redirect('/compte_information_personnelles')->with('success', "Modifications effectuées avec succès.");
    }

    public function newdelivery(Request $request)
    {
        $rules = [
            'newdelivery__civility' => ['required'],
            'newdelivery__namuser' => ['required', 'max:30'],
            'newdelivery__firstnamuser' => ['required', 'max:20'],

            'newdelivery__address' => ['required', 'max:100'],
            'newdelivery__postalzip' => ['required'],
            'newdelivery__city' => ['required', 'max:100'],
            'newdelivery__country' => ['required'],

            'newdelivery__telport' => ['required', 'regex:/[0][1-9](?:[\s]*\d{2}){4}/'],
            'newdelivery__tel' => ['nullable', 'regex:/^[0][1-9](?:[\s]*\d{2}){4}$/'],
            'newdelivery__addressname' => ['required', 'max:100'],
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect('/compte_information_personnelles')->withInput()->withErrors($validator);
        } else {
            $data = $request->input();

            // civility
            try {
                $civility = DB::table('civilites')->where('lib_civilite', $request->newdelivery__civility)->select('id')->first();
                $civilityid = $civility->id;
            } catch (Exception $e) {
                return redirect('/compte_information_personnelles')->withErrors(["Erreur lors de l'insertion de votre civilitées."]);
            }

            try {
                // POSTAL ZIP
                $code_postal = DB::table('code_postals')->where('lib_cp', $request->newdelivery__postalzip)->select('id')->first();
                if ($code_postal == null) {
                    $newcp = new CodePostal();
                    $newcp->pay_id = 1;
                    $newcp->lib_cp = $request->newdelivery__postalzip;
                    $newcp->save();

                    $idcode_postal = DB::table('code_postals')->where('lib_cp', $request->newdelivery__postalzip)->select('id')->first();
                    $idcode_postal = $idcode_postal->id;
                } else {
                    $idcode_postal = $code_postal->id;
                }
                // CITY
                try {
                    $city = DB::table('villes')->where('lib_ville', $request->newdelivery__city)->select('id')->first();
                    if ($city == null) {
                        $ville = new Ville();
                        $ville->code_postal_id = $idcode_postal;
                        $ville->lib_ville = $request->newdelivery__city;
                        $ville->save();
                        $idcity = DB::table('villes')->where('lib_ville', $request->newdelivery__city)->select('id')->first();
                        $idcity = $idcity->id;
                    } else {
                        $idcity = $city->id;
                    }
                } catch (Exception $e) {
                    return redirect('/compte_information_personnelles')->withErrors(["Erreur lors de l'insertion de la ville."]);
                }
            } catch (Exception $e) {
                return redirect('/compte_information_personnelles')->withErrors(["Erreur lors de l'insertion du code postal."]);
            }



            $deleteSpaceTel = str_replace(' ', '', $data['newdelivery__tel']);
            $deleteSpaceTelPort = str_replace(' ', '', $data['newdelivery__telport']);

            //global insert
            $deliveryinsert = new AdresseLivraison();

            $deliveryinsert->ville_id = $idcity;
            $deliveryinsert->civilite_id = $civilityid;
            $deliveryinsert->compte_client_id = $_COOKIE['account']['account_id'];
            $deliveryinsert->pay_id = 1;
            $deliveryinsert->code_postal_id = $idcode_postal;
            $deliveryinsert->nom_adresse = $data['newdelivery__addressname'];
            $deliveryinsert->nom = $data['newdelivery__namuser'];
            $deliveryinsert->prenom = $data['newdelivery__firstnamuser'];
            $deliveryinsert->adresse_livraison = $data['newdelivery__address'];
            $deliveryinsert->tel = $deleteSpaceTel;
            $deliveryinsert->tel_portable = $deleteSpaceTelPort;
            $deliveryinsert->save();



            // retrieve deliveries
            $deliveries = [];
            if ($deliveriesGet = AdresseLivraison::where('compte_client_id', '=', $_COOKIE['account']['account_id'])->first() == null) {
                return view('accountinfoperso')->with('deliveries', $deliveries);
            } else {
                $deliveriesGet = AdresseLivraison::where('compte_client_id', '=', $_COOKIE['account']['account_id'])->get()->toArray();
                // dd($deliveriesGet);
                foreach ($deliveriesGet as $delivery) {
                    //dd($delivery['id']);

                    $city = DB::table('villes')->where('id', $delivery['ville_id'])->first();
                    $lib_ville = $city->lib_ville;

                    $postal_zip = DB::table('code_postals')->where('id', $delivery['code_postal_id'])->first();
                    $lib_postal_zip = $postal_zip->lib_cp;

                    $civilite_id = DB::table('civilites')->where('id', $delivery['civilite_id'])->first();
                    $civilite_lib = $civilite_id->lib_civilite;

                    $newdelivery = array(
                        'id' => 14,
                        'nom_adresse' => $delivery['nom_adresse'],
                        'nom' => $delivery['nom'],
                        'prenom' => $delivery['prenom'],
                        'civilite_lib' => $civilite_lib,

                        'tel' => $delivery['tel'],
                        'tel_portable' => $delivery['tel_portable'],

                        'adresse_livraison' => $delivery['adresse_livraison'],
                        'ville_lib' => $lib_ville,
                        'code_postal_lib' => $lib_postal_zip,
                        'pay_id' => 1,
                    );

                    array_push($deliveries, $newdelivery);
                }
            }
        }
        return redirect('/compte_information_personnelles')->with('success', "Adresse de livraison crée avec succès.")->with('deliveries', $deliveries);
    }

    public function editdelivery($id, Request $request)
    {
        $rules = [
            'editdelivery__civility' => ['required'],
            'editdelivery__namuser' => ['required', 'max:30'],
            'editdelivery__firstnamuser' => ['required', 'max:20'],

            'editdelivery__address' => ['required', 'max:100'],
            'editdelivery__postalzip' => ['required'],
            'editdelivery__city' => ['required', 'max:100'],
            'editdelivery__country' => ['required'],

            'editdelivery__tel' => ['required', 'regex:/[0][1-9](?:[\s]*\d{2}){4}/'],
            'editdelivery__telport' => ['nullable', 'regex:/^[0][1-9](?:[\s]*\d{2}){4}$/'],
            'editdelivery__addressname' => ['required', 'max:50'],
        ];
        $validator = Validator::make($request->all(), $rules);

        $user_id = session()->get('account_id');

        if ($validator->fails()) {
            return redirect('/compte_information_personnelles')->withInput()->withErrors($validator);
        } else {
            $data = $request->input();

            // civility
            try {
                $civility = DB::table('civilites')->where('lib_civilite', $request->editdelivery__civility)->select('id')->first();
                $civilityid = $civility->id;
            } catch (Exception $e) {
                return redirect('/compte_information_personnelles')->withErrors(["Erreur lors de l'insertion de votre civilitées."]);
            }

            try {
                // POSTAL ZIP
                $code_postal = DB::table('code_postals')->where('lib_cp', $request->editdelivery__postalzip)->select('id')->first();
                if ($code_postal == null) {
                    $newcp = new CodePostal();
                    $newcp->pay_id = 1;
                    $newcp->lib_cp = $request->editdelivery__postalzip;
                    $newcp->save();

                    $idcode_postal = DB::table('code_postals')->where('lib_cp', $request->editdelivery__postalzip)->select('id')->first();
                    $idcode_postal = $idcode_postal->id;
                } else {
                    $idcode_postal = $code_postal->id;
                }
                // CITY
                try {
                    $city = DB::table('villes')->where('lib_ville', $request->editdelivery__city)->select('id')->first();
                    if ($city == null) {
                        $ville = new Ville();
                        $ville->code_postal_id = $idcode_postal;
                        $ville->lib_ville = $request->editdelivery__city;
                        $ville->save();
                        $idcity = DB::table('villes')->where('lib_ville', $request->editdelivery__city)->select('id')->first();
                        $idcity = $idcity->id;
                    } else {
                        $idcity = $city->id;
                    }
                } catch (Exception $e) {
                    return redirect('/compte_information_personnelles')->withErrors(["Erreur lors de l'insertion de la ville."]);
                }
            } catch (Exception $e) {
                return redirect('/compte_information_personnelles')->withErrors(["Erreur lors de l'insertion du code postal."]);
            }



            $deleteSpaceTel = str_replace(' ', '', $data['editdelivery__tel']);
            $deleteSpaceTelPort = str_replace(' ', '', $data['editdelivery__telport']);

            //update delivery
            DB::table('adresse_livraisons')->where('id', $id)->update([
                'ville_id' => $idcity,
                'civilite_id' => $civilityid,
                'pay_id' => 1,
                'code_postal_id' => $idcode_postal,
                'nom_adresse' => $data['editdelivery__addressname'],
                'nom' => $data['editdelivery__namuser'],
                'prenom' => $data['editdelivery__firstnamuser'],
                'adresse_livraison' => $data['editdelivery__address'],
                'tel' => $deleteSpaceTel,
                'tel_portable' => $deleteSpaceTelPort,
            ]);


            // retrieve deliveries
            $deliveries = [];
            if ($deliveriesGet = AdresseLivraison::where('compte_client_id', '=', $user_id)->first() == null) {
                return view('accountinfoperso')->with('deliveries', $deliveries);;
            } else {
                $deliveriesGet = AdresseLivraison::where('compte_client_id', '=', $user_id)->get()->toArray();
                // dd($deliveriesGet);
                foreach ($deliveriesGet as $delivery) {
                    //dd($delivery['id']);

                    $city = DB::table('villes')->where('id', $delivery['ville_id'])->first();
                    $lib_ville = $city->lib_ville;

                    $postal_zip = DB::table('code_postals')->where('id', $delivery['code_postal_id'])->first();
                    $lib_postal_zip = $postal_zip->lib_cp;

                    $civilite_id = DB::table('civilites')->where('id', $delivery['civilite_id'])->first();
                    $civilite_lib = $civilite_id->lib_civilite;

                    $newdelivery = array(
                        'id' => 14,
                        'nom_adresse' => $delivery['nom_adresse'],
                        'nom' => $delivery['nom'],
                        'prenom' => $delivery['prenom'],
                        'civilite_lib' => $civilite_lib,

                        'tel' => $delivery['tel'],
                        'tel_portable' => $delivery['tel_portable'],

                        'adresse_livraison' => $delivery['adresse_livraison'],
                        'ville_lib' => $lib_ville,
                        'code_postal_lib' => $lib_postal_zip,
                        'pay_id' => 1,
                    );

                    array_push($deliveries, $newdelivery);
                }
            }
        }
        return redirect('/compte_information_personnelles')->with('success', "Adresse de livraison modifiée avec succès.")->with('deliveries', $deliveries);
    }

    public function deletedelivery($id, Request $request)
    {
        $deleteDelivery = AdresseLivraison::where('id', $id)->delete();
        if ($deleteDelivery) {
            return redirect('/compte_information_personnelles')->with('success', "Adresse de livraison supprimé avec succès.");
        } else {
            return redirect('/compte_information_personnelles')->withErrors(["Erreur lors de la suppression de votre adresse."]);
        }
    }
}
