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
            'tahun' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'kode_mak' => 'MAK',
            'mak' => 'MAK',
            'kode_akun' => 'Akun',
            'akun' => 'Akun',
            'tahun' => 'Tahun',
        ];
    }
}