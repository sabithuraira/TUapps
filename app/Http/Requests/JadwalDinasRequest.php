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
            'tanggal_berakhir' => 'Tanggal Berakhir',
            'penjelasan' => 'Penjelasan',
            'print_no' => 'Nomor Surat',
            'print_unit_kerja' => 'Unit Kera',
            'print_ttd' => 'Tanda Tangan',
            'print_is_kepala' => 'Apakah persetujuan kepala?',
            'print_ttd_nip' => 'NIP. ',
            'is_lpd' => 'Status LPD',
            'is_kelengkapan' => 'Status Kelengkapan',
            'is_lunas_bayar' => 'Apakah telah lunas?',
            'created_by' => 'Dibuat oleh',
            'upated_by' => 'Terakhir diperbaharui oleh',
            'pegawai_id' => 'Pegawai',
        ];
    }
}
