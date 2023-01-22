<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConfirmSMSController extends Controller
{
    public function index(Request $request){
        // $basic  = new \Vonage\Client\Credentials\Basic("591708ad", "qCQ6hEx3TXBui4qr");
        // $client = new \Vonage\Client($basic);

        // $ran = rand(100000, 999999);

        // $response = $client->sms()->send(
        //    new \Vonage\SMS\Message\SMS("33782923806", "Miliboo SMS Confirmation", 'Votre code est: '. $ran .'\nNe le //divulguez à personne.')
        // );

        // $message = $response->current();
        // if ($message->getStatus() == 0) {
        //    echo "The message was sent successfully\n";
        // } else {
        //    echo "The message failed with status: " . $message->getStatus() . "\n";
        // }
        $message_code = 152894;

        if (isset($_GET['code']))
        {
            if ($_GET['code'] == $message_code)
            {
                return redirect('/')->with('success', "Connexion réussi.");
            }
            else
            {
                session()->put('controller', false);
                return view('smsConfirmWrong');
            }
        }

        return view('smsConfirm');
    }

    public function input(Request $request){
        return view('smsInput');
    }
}
