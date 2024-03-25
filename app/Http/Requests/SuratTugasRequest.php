<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SuratTugasRequest extends FormRequest
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
            // 'jenis_st' => 'required',
            'sumber_anggaran' => 'required',
            'tugas' => 'required',
        ];
    }
     
    public function attributes()
    {
        return [
            'jenis_st' => 'Jenis Surat Tugas',
            'sumber_anggaran' => 'Sumber Anggaran',
            'mak' => 'MAK',
            'tugas' => 'Tugas',
            'menimbang' => 'Menimbang',
            'mengingat' => 'Mengingat',
            'unit_kerja' => 'Unit Kerja',
            'created_by' => 'Dibuat oleh',
            'upated_by' => 'Terakhir diperbaharui oleh',
            
        ];
    }
}
