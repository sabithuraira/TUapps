<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PenugasanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    public function rules()
    {
        return [
            'isi' => 'required',
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required',
            'satuan' => 'required',
            'jenis_periode' => 'required',
        ];
    }
}
