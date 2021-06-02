<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SuratKmRequest extends FormRequest
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

    public function rules()
    {
        return [
        ];
    }

    public function messages()
    {
        return [
            // 'kode.required' => ':attribute tidak boleh kosong',
            // 'kode.unique' => ':attribute sudah ada',
            // 'nama.required' => ':attribute tidak boleh kosong',
        ];
    }

    public function attributes()
    {
        return [
            'nomor_urut' => 'No',
            'alamat' => 'Alamat',
            'tanggal' => 'Tanggal',
            'nomor' => 'Nomor',
            'perihal' => 'Perihal',
            'nomor_petunjuk' => 'Petunjuk',
            'jenis_surat' => 'Jenis Surat',
            'penerima' => 'Nama Penerima',
        ];
    }
}
