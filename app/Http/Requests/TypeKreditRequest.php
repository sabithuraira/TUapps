<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TypeKreditRequest extends FormRequest
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
            // 'created_by' => 'required',
            // 'updated_by' => 'required',
        ];
    }

    public function messages()
    {
        return [
            // 'uraian.required' => ':attribute tidak boleh kosong',
            // 'created_by.unique' => ':attribute sudah ada',
            // 'updated_by.required' => ':attribute tidak boleh kosong',
        ];
    }

    public function attributes()
    {
        return [
            'uraian' => 'Uraian',
        ];
    }
}
