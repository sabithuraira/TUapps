<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MeetingRequest extends FormRequest
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
            'judul' => 'required',
            'deskripsi' => 'required',
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
            'judul' => 'Judul',
            'is_secret' => 'Apakah rahasia?',
            'deskripsi' => 'Deskripsi',
            'notulen' => 'Notulen',
            'keterangan' => 'Keterangan',
            'waktu_mulai' => 'Waktu Mulai',
            'waktu_selesai' => 'Waktu Selesai',
        ];
    }
}
