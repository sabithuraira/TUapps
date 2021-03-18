<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UkerRequest extends FormRequest
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
            'kode' => 'required|unique:unit_kerjas|max:255',
            'nama' => 'required',
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
            'kode' => 'Kode Wilayah',
            'nama' => 'Nama',
        ];
    }
}
