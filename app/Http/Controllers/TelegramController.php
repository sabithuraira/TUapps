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
        $client = new \GuzzleHttp\Client();
     
        $update = json_decode($request->getContent());
        // Log::info('info request:', ['isi'=>$update]);
        $chatID = $update->message->chat->id;
        $message = $update->message->text; //$update["message"]["text"];
        // $options = json_encode(["OKU", "OKI", "Muara Enim"]);

        // $options_markup = json_encode([
        //     'resize_keyboard'=>true,
        //     'one_time_keyboard'=>true,
        //     'keyboard'=>[[['text'=>"OKU"],['text'=>"OKI"],['text'=>"Muara Enim"]],]
        // ]);

        $pesan = '';

        if(strtolower(str_replace(' ', '', $message))=='sp2020'){
            $pesan = "Kirim laporan progres Sensus Penduduk dengan format <strong><u>ID SLS/Non SLS - Estimasi Jumlah Penduduk - Jumlah Penduduk yang telah selesai</u></strong>. Contoh: <strong>1607110012000600 - 69 - 30</strong>";
        }
        else{
            $rincian_msg = explode("-", $message);
            if(count($rincian_msg)==3){
                $is_true = true;

                $id_sls = str_replace(' ', '', $rincian_msg[0]);
                $estimasi_penduduk = str_replace(' ', '', $rincian_msg[1]);
                $jumlah_selesai = str_replace(' ', '', $rincian_msg[2]);

                if(!is_numeric($id_sls)) $is_true = false;
                if(!is_numeric($estimasi_penduduk)) $is_true = false;
                if(!is_numeric($jumlah_selesai)) $is_true = false;

                if($is_true==false){
                    $pesan = "Isian <b>ID SLS</b>=$id_sls, <b>Estimasi Jumlah Penduduk</b>=$estimasi_penduduk dan <b>Jumlah Penduduk yang telah selesai</b>=$jumlah_selesai harus angka";
                }
                else if($estimasi_penduduk<$jumlah_selesai){
                    $pesan = "Bro/sis, isian <b>Jumlah Penduduk yang telah selesai</b> harus lebih kecil atau sama dengan isian <b>Estimasi Jumlah Penduduk</b>";
                }
                else{
                    $data = \App\Sp2020Sls::where([
                        ['id_sls', '=', $id_sls],
                    ])
                    ->first();
    
                    if($data==null){
                        $pesan = "ID SLS/Non SLS tidak ditemukan, silahkan ulangi lagi dengan ID SLS/Non SLS yang benar";
                    }
                    else{
                        $data->target_penduduk = $estimasi_penduduk;
                        $data->realisasi_penduduk = $jumlah_selesai;
                        $data->save();

                        $pesan = "Mantap.. data berhasil disimpan.";  
                    }
                }  
            }
            else{
                $pesan = "Format pesan anda salah. Balas dengan 'sp2020' untuk bantuan format yang benar";  
            }

            
        }

        // $API_message = "https://api.telegram.org/bot".env('TELEGRAM_TOKEN')."/sendmessage?chat_id=".$chatID."&text=".$pesan."&reply_markup=".$options_markup;
        // $API_poll = "https://api.telegram.org/bot".env('TELEGRAM_TOKEN')."/sendPoll?chat_id=".$chatID."&question=".$pesan."&options=".$options;


        $API_message = "https://api.telegram.org/bot".env('TELEGRAM_TOKEN')."/sendmessage?chat_id=".$chatID."&text=".$pesan."&parse_mode=HTML";
        
        $res = $client->get($API_message);

        return 1;
    }
}
