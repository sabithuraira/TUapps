<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Log;

class TelegramController extends Controller
{
    // public function sp2020(Request $request){
    //     $client = new \GuzzleHttp\Client();
     
    //     $update = json_decode($request->getContent());
    //     Log::info('info request:', ['isi'=>$update]);
    //     $chatID = $update->message->chat->id;
    //     $message = $update->message->text; //$update["message"]["text"];
    //     // $options = json_encode(["OKU", "OKI", "Muara Enim"]);

    //     // $options_markup = json_encode([
    //     //     'resize_keyboard'=>true,
    //     //     'one_time_keyboard'=>true,
    //     //     'keyboard'=>[[['text'=>"OKU"],['text'=>"OKI"],['text'=>"Muara Enim"]],]
    //     // ]);

    //     $pesan = '';

    //     if(strtolower(str_replace(' ', '', $message))=='sp2020'){
    //         $pesan = "Kirim laporan progres Sensus Penduduk dengan format <strong><u>ID SLS/Non SLS - Estimasi Jumlah Penduduk - Jumlah Penduduk yang telah selesai</u></strong>. Contoh: <strong>1607110012000600 - 69 - 30</strong>";
    //     }
    //     else{
    //         $rincian_msg = explode("-", $message);
    //         if(count($rincian_msg)==3){
    //             $is_true = true;

    //             $id_sls = str_replace(' ', '', $rincian_msg[0]);
    //             $estimasi_penduduk = str_replace(' ', '', $rincian_msg[1]);
    //             $jumlah_selesai = str_replace(' ', '', $rincian_msg[2]);

    //             if(!is_numeric($id_sls)) $is_true = false;
    //             if(!is_numeric($estimasi_penduduk)) $is_true = false;
    //             if(!is_numeric($jumlah_selesai)) $is_true = false;

    //             if($is_true==false){
    //                 $pesan = "Isian <b>ID SLS</b>=$id_sls, <b>Estimasi Jumlah Penduduk</b>=$estimasi_penduduk dan <b>Jumlah Penduduk yang telah selesai</b>=$jumlah_selesai harus angka";
    //             }
    //             else if($estimasi_penduduk<$jumlah_selesai){
    //                 $pesan = "Bro/sis, isian <b>Jumlah Penduduk yang telah selesai</b> harus lebih kecil atau sama dengan isian <b>Estimasi Jumlah Penduduk</b>";
    //             }
    //             else{
    //                 $data = \App\Sp2020Sls::where([
    //                     ['id_sls', '=', $id_sls],
    //                 ])
    //                 ->first();
    
    //                 if($data==null){
    //                     $pesan = "ID SLS/Non SLS/Sub SLS tidak ditemukan. Silahkan ulangi lagi dengan ID SLS/Non SLS yang benar";
    //                 }
    //                 else{
    //                     if($data->flag_update==1){
    //                         $pesan = "Maaf banget.. data SLS/Non SLS ini tidak bisa di update lagi karena dikunci BPS Kabupaten/Kota atau BPS Provinsi."; 
    //                     }
    //                     else{
    //                         $data->target_penduduk = $estimasi_penduduk;
    //                         $data->realisasi_penduduk = $jumlah_selesai;
    //                         $data->save();
    
    //                         $pesan = "Mantap.. data berhasil disimpan."; 
    //                     } 
    //                 }
    //             }  
    //         }
    //         else{
    //             $pesan = "Format pesan anda salah. Balas dengan 'sp2020' untuk bantuan format yang benar";  
    //         }

            
    //     }

    //     // $API_message = "https://api.telegram.org/bot".env('TELEGRAM_TOKEN')."/sendmessage?chat_id=".$chatID."&text=".$pesan."&reply_markup=".$options_markup;
    //     // $API_poll = "https://api.telegram.org/bot".env('TELEGRAM_TOKEN')."/sendPoll?chat_id=".$chatID."&question=".$pesan."&options=".$options;


    //     $API_message = "https://api.telegram.org/bot".env('TELEGRAM_TOKEN')."/sendmessage?chat_id=".$chatID."&text=".$pesan."&parse_mode=HTML";
        
    //     $res = $client->get($API_message);

    //     return 1;
    // }

    public function sp2020lf(Request $request)
    {
        // $client = new \GuzzleHttp\Client();
        // $update = json_decode($request->getContent());
        // Log::info('info request:', ['isi'=>$update]);
        // $chatID = $update->message->chat->id;
        // $message = $update->message->text;
        
        // $message = "LF.P-1605070031009B-80-89-102-4";
        // $message = "LF.C2-1605070031009B-3-1-Ahmad joko-3-1-0";
        
        // Listing: LF.P-id_bs-jlhrutahasil-Pddkhasillaki-Pddkhasilperempuan-JlhrutaAdaKematian (LF.P-1681052001004B-80-89-102-4)
        // Sampel: LF.C2-id_bs-status-namaKRT-pendidikanKRT-jlhARTLaki-jlhARTPerempuan-jmlARTPerempuan15sd49-jlhkematian  
        //        (LF.C2-1681052001004B-1-Ahmad joko-5-2-3-1-0)

        $pesan = '';

        if(strtolower(str_replace(' ', '', $message))=='panduan'){
            $pesan = urlencode("Kirim laporan progres Long Form SP2020 dengan format berikut: \n
                <strong>PEMUTAKHIRAN</strong>: LF.P- ID BS - Jumlah Rumah Tangga - Jumlah Penduduk Laki-laki -  Jumlah Penduduk Perempuan - Jumlah Rumah Tangga Ada Kematian. Contoh: <pre>LF.P-1681052001004B-80-89-102-4</pre> \n
                <strong>PENDATAAN C2</strong>: LF.C2- ID BS - No Urut Rumah Tangga Sampel (Rincian 109) - Status Kunjungan - Nama KRT - Jumlah ART - Jumlah ART Perempuan Usia 10 s/d 54 Tahun - Jumlah Kematian. Contoh: <code>LF.C2-1681052001004B-3-1-Ahmad joko-5-1-0</code>");
        }
        else{
            $lower_msg = strtolower($message);
            $rincian_msg = explode("-", $lower_msg);

            if(count($rincian_msg)==6 || count($rincian_msg)==8){
                $msg_error = [];

                $id_bs = str_replace(' ', '', $rincian_msg[1]);
                if(count($rincian_msg)==6){
                    // (LF.P-1681052001004B-80-89-102-4)
                    if(str_replace(' ', '', $rincian_msg[0])=="lf.p"){
                        $jumlah_ruta = str_replace(' ', '', $rincian_msg[2]);
                        $jumlah_laki = str_replace(' ', '', $rincian_msg[3]);
                        $jumlah_perempuan = str_replace(' ', '', $rincian_msg[4]);
                        $jumlah_mati = str_replace(' ', '', $rincian_msg[5]);
                        
                        //cek numerik
                        if(!is_numeric($jumlah_ruta)) $msg_error[] = "Isian 'Jumlah Rumah Tangga' Harus Angka";
                        if(!is_numeric($jumlah_laki)) $msg_error[] = "Isian 'Jumlah Penduduk Laki-laki' Harus Angka";
                        if(!is_numeric($jumlah_perempuan)) $msg_error[] = "Isian 'Jumlah Penduduk Perempuan' Harus Angka";
                        if(!is_numeric($jumlah_mati)) $msg_error[] = "Isian 'Jumlah Rumah Tangga Ada Kematian' Harus Angka";

                        //cek jumlah RT cant more than jumlah laki+perempuan
                        if(count($msg_error)==0){
                            if($jumlah_ruta>=($jumlah_perempuan+$jumlah_laki)) $msg_error[] = "Isian Jumlah RT tidak boleh lebih besar sama dengan dari Jumlah Perempuan+Jumlah Laki-laki";
                        }
                        /////

                        /////////
                        if(count($msg_error)>0){
                            $pesan = "Error!! berikut rincian errornya ya kak: ".join(",", $msg_error);
                        }
                        else{
                            $data = \App\Sp2020LfBs::where([['idbs', '=', $id_bs],])->first();
            
                            if($data==null){
                                $pesan = "Identitas Blok Sensus ini tidak ditemukan, kayaknya kamu salah masukin ID BS-nya ya..";
                            }
                            else{
                                $data->jumlah_ruta = $jumlah_ruta;
                                $data->jumlah_laki = $jumlah_laki;
                                $data->jumlah_perempuan = $jumlah_perempuan;
                                $data->jumlah_ruta_ada_mati = $jumlah_mati;
                                $data->save();
                                $pesan = "Sukses.. data berhasil disimpan.";  
                            }
                        } 
                        /////////
                    }
                    else{
                        $pesan = "Format pesan kamu salah. Balas pesan ini dengan pesan 'panduan' untuk bantuan format yang benar";  
                    }
                }
                else if(count($rincian_msg)==8){
                    if(str_replace(' ', '', $rincian_msg[0])=="lf.c2"){
                        $nurts = str_replace(' ', '', $rincian_msg[2]);
                        $status_ruta = str_replace(' ', '', $rincian_msg[3]);
                        $nama_krt = $rincian_msg[4];
                        $jumlah_art = str_replace(' ', '', $rincian_msg[5]);
                        $jumlah_perempuan1549 = str_replace(' ', '', $rincian_msg[6]);
                        $jumlah_mati = str_replace(' ', '', $rincian_msg[7]);
                        
                        if(!is_numeric($nurts)) {
                            $msg_error[] = "Isian 'Nomor Urut Rumah Tangga Sampel' Harus Angka";
                        }
                        else{
                            if($nurts<1 || $nurts>16) $msg_error[] = "Isian 'Nomor Urut Rumah Tangga Sampel' harus diantara 1 dan 16";
                        }
                        
                        if(!is_numeric($status_ruta)) {
                            $msg_error[] = "Isian 'Status Kunjungan' Harus Angka";
                        }
                        else{
                            if($status_ruta<1 || $status_ruta>2) $msg_error[] = "Isian 'Status Kunjungan' Harus diantara angka 1-2";
                        }
                        
                        if(!is_numeric($jumlah_art)) $msg_error[] = "Isian 'Jumlah ART' Harus Angka";
                        if(!is_numeric($jumlah_perempuan1549)) $msg_error[] = "Isian 'Jumlah ART Perempuan Usia 15-49 Tahun' Harus Angka";
                        if(!is_numeric($jumlah_mati)) $msg_error[] = "Isian 'Jumlah ART Mati' Harus Angka";

                        /////////
                        if(count($msg_error)>0){
                            $pesan = "Error!! berikut rincian errornya ya kak: ".join(",", $msg_error);
                        }
                        else{
                            $data = \App\Sp2020LfBs::where([['idbs', '=', $id_bs]])->first();
            
                            if($data==null){
                                $pesan = "Identitas Blok Sensus ini tidak ditemukan, kayaknya kamu salah masukin ID Blok sensus-nya ya..";
                            }
                            else{
                                
                                if($data->jumlah_ruta=='' || $data->jumlah_ruta==null){
                                    $pesan = "Blok Sensus ini belum selesai tahap pemutakhiran, silahkan laporkan dahulu";
                                }
                                else{
                                    $model = \App\Sp2020LfRt::where([['idbs', '=', $id_bs], ['nurts', '=', $nurts]])->first();

                                    if($model==null){
                                        $model = new \App\Sp2020LfRt;
                                        $model->kd_prov = substr($id_bs, 0,2);
                                        $model->kd_kab = substr($id_bs, 2,2);
                                        $model->kd_kec = substr($id_bs, 4,3);
                                        $model->kd_desa = substr($id_bs, 7,3);
                                        $model->idbs = $id_bs;
                                        $model->nurts = $nurts;
                                    }
    
                                    $model->status_rt =  $status_ruta;
                                    $model->nama_krt =  $nama_krt;
                                    $model->jumlah_art =  $jumlah_art;
                                    $model->jumlah_perempuan_1549 =  $jumlah_perempuan1549;
                                    $model->jumlah_mati =  $jumlah_mati;
                                    $model->save();
    
                                    $pesan = "Sukses.. data berhasil disimpan.";  
                                }
                            }
                        } 
                        /////////
                    }
                    else{
                        $pesan = "Format pesan anda salah. Balas pesan ini dengan 'panduan' untuk bantuan format yang benar";  
                    }
                } 
                else{
                    $pesan = "Format pesan anda salah. Balas pesan ini dengan pesan 'panduan' untuk bantuan format yang benar";  
                }
            }
            else{
                $pesan = "Format pesan anda salah. Balas pesan ini dengan pesan 'panduan' untuk bantuan format yang benar";  
            }
        }
        // $API_message = "https://api.telegram.org/bot".env('TELEGRAM_TOKEN_LF')."/sendmessage?chat_id=".$chatID."&text=".$pesan."&parse_mode=HTML";        
        // $res = $client->get($API_message);
        return $pesan;

        // return 1;
    }
}
