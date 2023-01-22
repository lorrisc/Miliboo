<?php

namespace App\Http\Controllers;

use App\Models\Compte_client;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class AccountPasswordController extends Controller
{
    public function index()
    {   
        return view('accountpassword');
        
    }

    public function editpassword(Request $request)
    {



        $rules = [
            'passwordfield' => ['required', 'string', 'min:12', 'regex:/[a-z]/',  'regex:/[A-Z]/',  'regex:/[0-9]/', 'regex:/[`!@#$%^&*()_+\-=\[\]{};\':"\|,.<>\/?~]/', 'confirmed'],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect('/compte_password')->withInput()->withErrors($validator);
        } else {
            $data = $request->input();

            try {
                $updatePwd = $data['passwordfield'];

                $user_id = $_COOKIE['account_id'];
                $account_rq = DB::table('compte_clients')->where('id', $user_id)->first();

                $account_pwd = Crypt::decrypt($account_rq->password);

                if ($data['editpassword__oldpass'] == $account_pwd) {
                    try {
                        DB::table('compte_clients')->where('id', $user_id)->update(['password' => Crypt::encrypt($updatePwd)]);
                        return redirect('/compte_password')->with('success', "Modification effectuée.");
                    } catch (Exception $e) {
                        return redirect('/compte_password')->withErrors(["Erreur de modification. Veuillez réessayer."]);
                    }
                }
            } catch (Exception $e) {
                return redirect('/compte_password')->withErrors(["Mot de passe erroné."]);
            }
        }
    }
}
