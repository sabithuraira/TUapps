<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CkpRequest extends FormRequest
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
            'month' => 'required|numeric',
            'year' => 'required|numeric',
            'type' => 'required|numeric',
            'uraian' => 'required|max:255',
            'satuan' => 'required|max:255',
            'target_kuantitas' => 'required|numeric',
            'realisasi_kuantitas' => 'required|numeric',
            'kualitas' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            // 'butir_kegiatan.required' => ':attribute tidak boleh kosong',
            // 'jenis.unique' => ':attribute sudah ada',
            // 'satuan_hasil.required' => ':attribute tidak boleh kosong',
            // 'kode.required' => ':attribute tidak boleh kosong',
            // 'angka_kredit.required' => ':attribute tidak boleh kosong',
            // 'pelaksana.required' => ':attribute tidak boleh kosong',
            // 'bukti_fisik.required' => ':attribute tidak boleh kosong',
        ];
    }

    public function attributes()
    {
        return [
            'user_id' => 'User',
            'month' => 'Bulan',
            'year' => 'Tahun',
            'type' => 'Jenis',
            'uraian' => 'Uraian',
            'satuan' => 'satuan',
            'target_kuantitas' => 'Kuantitas',
            'realisasi_kuantitas' => 'Kuantitas',
            'kualitas' => 'Kualitas',
            'kode_butir' => 'Kode Butir',
            'angka_kredit' => 'Angka Kredit',
            'keterangan' => 'Katerangan',
            'created_by' => 'Dibuat oleh',
            'updated_by' => 'Terkahir diperbaharui oleh',
            'created_at' => 'Dibuat pada',
            'updated_at' => 'Terakhir diperbaharui pada',
        ];
    }
}
