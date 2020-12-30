<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MataAnggaranRequest extends FormRequest
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
            'kode_program' => 'required',
            'label_program' => 'required',
            'kode_aktivitas' => 'required',
            'label_aktivitas' => 'required',
            'kode_kro' => 'required',
            'label_kro' => 'required',
            'kode_ro' => 'required',
            'label_ro' => 'required',
            'kode_komponen' => 'required',
            'label_komponen' => 'required',
            'kode_subkomponen' => 'required',
            'label_subkomponen' => 'required',
        ];
    }


    public function attributes()
    {
        return [
            'kode_program' => 'Program',
            'label_program' => 'Program',
            'kode_aktivitas' => 'Aktivitas',
            'label_aktivitas' => 'Aktivitas',
            'kode_kro' => 'KRO',
            'label_kro' => 'KRO',
            'kode_ro' => 'RO',
            'label_ro' => 'RO',
            'kode_komponen' => 'Komponen',
            'label_komponen' => 'Komponen',
            'kode_subkomponen' => 'Sub Komponen',
            'label_subkomponen' => 'Sub Komponen',
        ];
    }
}
