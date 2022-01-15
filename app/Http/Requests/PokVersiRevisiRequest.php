<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PokVersiRevisiRequest extends FormRequest
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
            'versi' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'versi' => 'Versi',
            'keterangan' => 'Keterangan',
        ];
    }
}
