<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegsosekSlsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(){
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(){
        return [
            'kode_kab' => 'required',
            'kode_kec' => 'required',
            'kode_desa' => 'required',
            'id_sls' => 'required',
            'id_sub_sls' => 'required',
            'nama_sls' => 'required',
        ];
    }
}
