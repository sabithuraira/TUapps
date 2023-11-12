<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SiraAkunRealisasiRequest extends FormRequest
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
            'kode_fungsi' => 'required',
            'realisasi' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'kode_mak' => 'Kode MAK',
            'kode_akun' => 'Kode Akun',
            'kode_fungsi' => 'Fungsi',
            'realisasi' => 'Realisasi',
            'keterangan' => 'Keterangan',
        ];
    }
}
