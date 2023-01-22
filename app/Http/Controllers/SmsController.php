<?php

namespace App\Http\Controllers;
use App\Models\CompteClient;
use Illuminate\Http\Request;

class SmsController extends Controller
{
    public function sendSms(Request $request, $id){
        $basic  = new \Vonage\Client\Credentials\Basic("591708ad", "qCQ6hEx3TXBui4qr");
        $client = new \Vonage\Client($basic);
        //dd($request);
        $tel = CompteClient::where('id', '=', $id)->get('tel_portable')->toArray();
        //dd($tel);

        $texte = $request->input('message');

        //dd(substr($tel[0]['tel_portable'],1,9));

        $response = $client->sms()->send(
            new \Vonage\SMS\Message\SMS('33' . substr($tel[0]['tel_portable'],1,9), 'Miliboo', 'Bonjour' . "\n" . "\n" . $texte . "\n" . "\n" . 'Cordialement Miliboo')
        );

        $message = $response->current();

        if ($message->getStatus() == 0) {
            echo "The message was sent successfully\n";
        } else {
            echo "The message failed with status: " . $message->getStatus() . "\n";
        }
    }
}
