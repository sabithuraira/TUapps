<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RincianKreditRequest extends FormRequest
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
            'uraian' => 'required|max:255',
            'jenis' => 'required',
            'kode' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'uraian.required' => ':attribute tidak boleh kosong',
            'jenis.unique' => ':attribute sudah ada',
            'kode.required' => ':attribute tidak boleh kosong',
        ];
    }

    public function attributes()
    {
        return [
            'uraian' => 'Uraian',
            'jenis' => 'Peruntukan',
            'Kode' => 'Kode',
        ];
    }
}
