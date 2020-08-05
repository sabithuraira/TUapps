<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TelegramController extends Controller
{
    public function sp2020(Request $request)
    { 
        $pesan = json_encode("halo dong");
        $API = "https://api.telegram.org/bot".env('TELEGRAM_TOKEN')."/sendmessage?chat_id=441016770&text=$pesan";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_URL, $API);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}
