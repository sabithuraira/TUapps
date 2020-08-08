<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Log;

class TelegramController extends Controller
{
    public function sp2020(Request $request)
    {
        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        // curl_setopt($ch, CURLOPT_URL, $API);
        // $result = curl_exec($ch);
        // curl_close($ch);
        // return $result;

        $client = new \GuzzleHttp\Client();
        // $response = $client->request('GET', 'https://api.github.com/repos/guzzle/guzzle');
        // $content = (string) $res->getBody();

        $update = json_decode($request->getContent());
        // Log::info('info request:', ['isi'=>$update]);
        $chatID = $update->message->chat->id;
        $message = $update->message->text; //$update["message"]["text"];
        $options = json_encode(["OKU", "OKI", "Muara Enim"]);

        $options_markup = json_encode([
            'resize_keyboard'=>true,
            'one_time_keyboard'=>true,
            'keyboard'=>[[['text'=>"OKU"],['text'=>"OKI"],['text'=>"Muara Enim"]],]
        ]);

        $pesan = "Haloo ".$message.", test again webhooks <code>dicoffeean.com</code>.&parse_mode=HTML";
        $API_message = "https://api.telegram.org/bot".env('TELEGRAM_TOKEN')."/sendmessage?chat_id=".$chatID."&text=".$pesan."&reply_markup=".$options_markup;
        $API_poll = "https://api.telegram.org/bot".env('TELEGRAM_TOKEN')."/sendPoll?chat_id=".$chatID."&question=".$pesan."&options=".$options;

        $res = $client->get($API_message);

        return 1;

        // echo $response->getStatusCode(); # 200
        // echo $response->getHeaderLine('content-type'); # 'application/json; charset=utf8'
        // echo $response->getBody(); # '{"id": 1420053, "name": "guzzle", ...}'


        // $apiURL = "https://api.telegram.org/bot".env('TELEGRAM_TOKEN');
        // $update = json_decode(file_get_contents("php://input"), TRUE);
        // $chatID = $update["message"]["chat"]["id"];
        // $message = $update["message"]["text"];
        
        // if (strpos($message, "/start") === 0) {
        //     file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=Haloo, test webhooks <code>dicoffeean.com</code>.&parse_mode=HTML");
        // }
    }
}
