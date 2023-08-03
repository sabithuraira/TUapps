<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CutiRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nama' => 'required',
            // 'nip' => 'required',
            // 'jabatan' => 'required',
            // 'masa_kerja' => 'required',
            'jenis_cuti' => 'required',
            'alasan_cuti' => 'required',
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required',
            // 'lama_cuti' => 'required|numeric',
            'lama_cuti_hari_kerja' => 'required|numeric',
            'lama_cuti_hari_libur' => 'required|numeric',
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
            'alamat_cuti' => 'Alamat Selama Cuti',
            'no_telp' => 'No. Telp / Hp (Aktif)',
            'unit_kerja' => 'Unit Kerja',
            'created_by' => 'Dibuat oleh',
            'upated_by' => 'Terakhir diperbaharui oleh',
            'atasan' => 'Atasan yang memberikan izin',
            'pejabat' => 'Pejabat yang Berwenang Memberikan Cuti'
        ];
    }
}
