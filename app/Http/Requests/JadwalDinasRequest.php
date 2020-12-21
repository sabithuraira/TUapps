<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JadwalDinasRequest extends FormRequest
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
            'nama_kegiatan' => 'required|max:255',
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required',
            'pegawai_id' => 'required',
            'penjelasan' => 'required',
            'nomor_surat' => 'required',

        ];
    }

    public function messages()
    {
        return [
        ];
    }

     
    public function attributes()
    {
        return [
            'nama_kegiatan' => 'Nama Kegiatan',
            'tanggal_mulai' => 'Tanggal Mulai',
            'tanggal_selesai' => 'Tanggal Selesai',
            'penjelasan' => 'Penjelasan',

            'nomor_surat' => 'Nomor Surat',
            'pejabat_ttd' => 'Pejabat Pemberi Tanda Tangan',
            'is_kepala' => 'Apakah persetujuan kepala?',
    
            'is_lpd' => 'Kelengkapan LPD',
            'is_kelengkapan' => 'Kelengkapan Dokumen Lainnya',
            'is_lunas' => 'Pelunasan Pembayaran',
            'created_by' => 'Dibuat oleh',
            'upated_by' => 'Terakhir diperbaharui oleh',
            'pegawai_id' => 'Pegawai ',
        ];
    }
}
