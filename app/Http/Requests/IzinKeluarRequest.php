<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IzinKeluarRequest extends FormRequest
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
            'pegawai_nip' => 'required',
            'start' => 'required',
            'keterangan' => 'required',
        ];
    }

    public function messages()
    {
        return [
        ];
    }

    public function attributes()
    {
        return [
            'pegawai_nip' => 'Pegawai',
            'tanggal' => 'Tanggal',
            'start' => 'Mulai',
            'end' => 'Selesai',
            'keterangan' => 'Keterangan',
            'created_by' => 'Dibuat oleh',
            'updated_by' => 'Terkahir diperbaharui oleh',
            'created_at' => 'Dibuat pada',
            'updated_at' => 'Terakhir diperbaharui pada',
        ];
    }
}
