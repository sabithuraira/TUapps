<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class FingerprintAPI extends Controller
{
    public function user(Request $request)
    {
        $data = User::select('id', 'name', 'email', 'nip_baru', 'fingerprint')->where('kdkab', '00')->orderBy('nip_baru', 'asc')->get()->each(function ($user) {
            $user->setAppends([]); // Menghilangkan semua properti di `$appends` untuk pemanggilan ini
        });

        if ($data->isNotEmpty()) {
            $res = [
                'message' => 'success',
                'data' => $data
            ];
            return response($res);
        } else {
            $res = [
                'message' => 'data kosong',
            ];
            return response($res);
        }
    }
}
