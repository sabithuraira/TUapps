<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TelegramController extends Controller
{
    public function sp2020(Request $request)
    { 
        $pesan = "Haloo, test webhooks <code>dicoffeean.com</code>.&parse_mode=HTML";
        $API = "https://api.telegram.org/bot".env('TELEGRAM_TOKEN')."/sendmessage?chat_id=441016770&text=$pesan";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_URL, $API);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;

        // $apiURL = "https://api.telegram.org/bot".env('TELEGRAM_TOKEN');
        // $update = json_decode(file_get_contents("php://input"), TRUE);
        // $chatID = $update["message"]["chat"]["id"];
        // $message = $update["message"]["text"];
        
        // if (strpos($message, "/start") === 0) {
        //     file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=Haloo, test webhooks <code>dicoffeean.com</code>.&parse_mode=HTML");
        // }
    }
}
