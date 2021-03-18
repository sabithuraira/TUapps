<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AngkaKreditRequest extends FormRequest
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
            'butir_kegiatan' => 'required|max:255',
            'jenis' => 'required',
            'satuan_hasil' => 'required',
            'kode' => 'required',
            'angka_kredit' => 'required|numeric',
            'pelaksana' => 'required',
            'bukti_fisik' => 'required',
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
            'jenis' => 'Peruntukan',
            'kode' => 'kode',
            'butir_kegiatan' => 'Butir Kegiatan',
            'satuan_hasil' => 'Satuan Hasil',
            'angka_kredit' => 'Angka Kredit',
            'batas_penilaian' => 'Batas Penilaian',
            'pelaksana' => 'Pelaksana Bukti',
            'bukti_fisik' => 'Bukti Fisik',
        ];
    }
}
