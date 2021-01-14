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
            'kode_program' => 'Kode Program',
            'label_program' => 'Label Program',
            'kode_aktivitas' => 'Kode Aktivitas',
            'label_aktivitas' => 'Label Aktivitas',
            'kode_kro' => 'Kode KRO',
            'label_kro' => 'Label KRO',
            'kode_ro' => 'Kode RO',
            'label_ro' => 'Label RO',
            'kode_komponen' => 'Kode Komponen',
            'label_komponen' => 'Label Komponen',
            'kode_subkomponen' => 'Kode Sub Komponen',
            'label_subkomponen' => 'Label Sub Komponen',
        ];
    }
}
