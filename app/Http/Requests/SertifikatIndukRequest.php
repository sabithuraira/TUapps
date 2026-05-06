<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SertifikatIndukRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'kegiatan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal' => 'required|date',
            'kode_satker' => 'required|string|max:255',
            'klasifikasi_arsip' => 'required|string|max:255',
            'peserta_nama' => 'nullable|array',
            'peserta_nama.*' => 'nullable|string|max:255',
            'excel_peserta' => 'nullable|file|mimes:xlsx,xls,csv',
        ];
    }
}
