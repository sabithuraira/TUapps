<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PokRevisiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            'kak' => 'required|mimes:pdf',
            'nota_dinas' => 'required|mimes:pdf',
            'matrik_anggaran' => 'required|mimes:pdf',
            'judul' => 'required',
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

    public function attributes(){
        return [
            'judul' => 'Judul',
            'keterangan' => 'Keterangan',
            'kak' => 'KAK',
            'nota_dinas' => 'Nota Dinas',
            'matrik_anggaran' => 'Matrik Anggaran Sebelum & Sesudah',
            'status_revisi' => 'Status',
            'approved_ppk_by' => 'PPK yang memberikan approve',
            'execute_binagram_by' => 'Petugas yang mengeksekusi revisi',
        ];
    }
}
