<?php

namespace App\Http\Controllers;

use App\Models\CodePostal;
use App\Models\Ville;
use Exception;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NouvelleBoutique extends Controller
{
    public function index()
    {
        return view('boutiques');
    }

    public function addShop(Request $request)
    {
        $rules = [
            'titleboutique' => ['required'],
            'telboutique' => ['nullable', 'regex:/^[0][1-9](?:[\s]*\d{2}){4}$/'],
            //regex for validate phone. Only : 0X XX XX XX XX || OXXXXXXXXX
            'mailboutique' => ['required', 'regex:/\b[\w\.-]+@[\w\.-]+\.\w{2,4}\b/'],
            'indicationboutique' => ['required'],
            'useradress' => ['required'],
            'postalzip' => ['required'],
            'city' => ['required'],
            'country' => ['required'],
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect('nouvelleboutique')->withInput()->withErrors($validator);
        } else {
            $data = $request->input();

            $deleteSpaceTel = str_replace(' ', '', $request->telboutique);


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
                    return redirect('nouvelleboutique')->withErrors(["Erreur lors de l'insertion de la ville."]);
                }
            } catch (Exception $e) {
                return redirect('nouvelleboutique')->withErrors(["Erreur lors de l'insertion du code postal."]);
            }



            DB::table('boutiques')->insert([
                'titre' => $request->titleboutique,
                'ville_id' => $idcity,
                'code_postal_id' => $idcode_postal,
                'adresse' => $request->useradress,
                'tel' =>  $deleteSpaceTel,
                'mail' =>  $request->mailboutique
            ]);

            DB::table('acces_boutique')->insert([
                'indication' => $request->indicationboutique
            ]);

            $boutiqueid = DB::table('boutiques')->where('titre', $request->titleboutique)->select('id')->first();

            $accesid = DB::table('acces_boutique')->where('indication', $request->indicationboutique)->select('id')->first();

            DB::table('pivot_acces_boutiques')->insert([
                'boutique_id' => $boutiqueid->id,
                'acces_boutique_id' => $accesid->id
            ]);
        }
        return view('boutiques');
    }
}
