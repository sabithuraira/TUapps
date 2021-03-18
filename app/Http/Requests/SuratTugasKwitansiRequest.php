<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SuratTugasKwitansiRequest extends FormRequest
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
        ];
    }

    public function attributes()
    {
        return [
            'id_surtug' => 'Induk Surat Tugas',
            'id_surtug_pegawai' => 'Induk Surat Spesifik Pegawai',
            'rincian' => 'Rincian',
            'anggaran' => 'Anggaran',
            'is_rill' => 'Apakah pengeluaran rill?',
            'created_by' => 'Dibuat oleh',
            'upated_by' => 'Terakhir diperbaharui oleh',
        ];
    }
}
