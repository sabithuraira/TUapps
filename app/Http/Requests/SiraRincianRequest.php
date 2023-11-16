<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SiraRincianRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'kode_mak' => 'required',
            'kode_akun' => 'required',
            'kode_fungsi' => 'required',
            'jenis' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'kode_mak' => 'Kegiatan',
            'kode_akun' => 'MAK',
            'kode_fungsi' => 'Fungsi',
            'jenis' => 'Jenis',
            'path_kak' => 'KAK',
            'path_form_permintaan' => 'Form Permintaan',
            'path_notdin' => 'Nota Dinas',
            'path_undangan' => 'Undangan',
            'path_bukti_pembayaran' => 'Bukti Pembayaran',
            'path_kuitansi' => 'Kuitansi',
            'path_notulen' => 'Notulen',
            'path_daftar_hadir' => 'Daftar Hadir',
            'path_sk' => 'SK',
            'path_st' => 'Surat Tugas',
        ];
    }
}
