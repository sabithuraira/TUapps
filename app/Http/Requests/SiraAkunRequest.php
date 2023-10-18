<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SiraAkunRequest extends FormRequest
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
            'mak' => 'required',
            'kode_akun' => 'required',
            'akun' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'id_pemegang' => 'Pegawai Pemegang',
            'nip_baru' => 'NIP',
            'nama' => 'Nama',
            'nama_barang' => 'Nama Barang',
            'serial_number' => 'SN / Plat / Kode Unique Barang',
            'deskripsi_barang' => 'Deskripsi Barang (Tautan BAST, keterangan barang, kondisi, dll)',
        ];
    }
}
