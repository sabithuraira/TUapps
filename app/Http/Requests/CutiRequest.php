<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CutiRequest extends FormRequest
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
            'nama' => 'required',
            'nip' => 'required',
            'jabatan' => 'required',
            'masa_kerja' => 'required',
            'jenis_cuti' => 'required',
            'alasan_cuti' => 'required',
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required',
            'lama_cuti' => 'required|numeric',
            'alamat_cuti' => 'required',
            'no_telp' => 'required',
        ];
    }
    public function attributes()
    {
        return [
            'nama' => 'Nama Pengaju Cuti',
            'jabatan' => 'Jabatan',
            'masa_kerja' => 'Masa Kerja',
            'jenis_cuti' => 'Jenis Cuti',
            'alasan_cuti' => 'Alasan Cuti',
            'tanggal_mulai' => 'Tanggal Mulai',
            'tanggal_selesai' => 'Tanggal Selesai',
            'lama_cuti' => 'Lama Cuti (Hari)',
            'alamat_cuti' => 'Alamat Selamat Cuti',
            'no_telp' => 'No. Telp / Hp (Aktif)',
            'unit_kerja' => 'Unit Kerja',
            'created_by' => 'Dibuat oleh',
            'upated_by' => 'Terakhir diperbaharui oleh',
            'pejabat' => 'Pejabat yang Berwenang Memberikan Cuti'

        ];
    }
}
