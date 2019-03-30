<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LogBookRequest extends FormRequest
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
            'tanggal' => 'required',
            'isi' => 'required',
            'waktu' => 'required',
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
            'user_id' => 'User',
            'tanggal' => 'Tanggal',
            'isi' => 'Isi',
            'is_approve' => 'Status Approve',
            'waktu' =>  'Waktu',
            'flag_ckp'  => 'Referensi CKP',
            'catatan_approve' => 'Catatan Pimpinan',
            'created_by' => 'Dibuat oleh',
            'updated_by' => 'Terkahir diperbaharui oleh',
            'created_at' => 'Dibuat pada',
            'updated_at' => 'Terakhir diperbaharui pada',
        ];
    }
}
