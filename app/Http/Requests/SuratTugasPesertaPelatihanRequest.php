<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SuratTugasPesertaPelatihanRequest extends FormRequest
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
            'nip' => 'NIP',
            'nama' => 'Nama Pegawai',
            'gol' => 'Golongan',
            'jabatan' => 'Jabatan',
            'jabatan_pelatihan' => 'Jabatan Pelatihan',
            'asal_daerah' => 'Asal Daerah',
            'unit_kerja' => 'Unit Kerja',
            'jenis_peserta' => 'Jenis Peserta',
            'tingkat_biaya' => 'Tingkat Biaya',
            'kendaraan' => 'Alat Angkutan yang dipergunakan',
            'created_by' => 'Dibuat oleh',
            'upated_by' => 'Terakhir diperbaharui oleh',
        ];
    }
}
