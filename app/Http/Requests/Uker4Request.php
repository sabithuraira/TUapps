<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Uker4Request extends FormRequest
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
            'is_kabupaten' => 'required',
            'nama' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'is_kabupaten' => 'Apakah Unit Kerja Khusus Kabupaten',
            'nama' => 'Nama',
        ];
    }
}
