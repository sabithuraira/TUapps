<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SuratTugasRincianRequest extends FormRequest
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
            'jabatan' => 'Jabatan',
            'tujuan_tugas' => 'Tujuan',
            'tanggal_mulai' => 'Tanggal Mulai',
            'tanggal_selesai' => 'Tanggal Selesai',
            'nomor_st' => 'Nomor Surat Tugas',
            'nomor_sppd' => 'Nomor SPD',
            'status_kumpul_lpd' => 'Status Pengumpulan LPD',
            'status_kumpul_kelengkapan' => 'Status Pengumpulan Kelengkapan',
            'status_pembayaran' => 'Status Pembayaran',
            'pejabat_ttd_nip' => 'Pejabat yang Menandatangani',
            'pejabat_nama_ttd' => 'Nama Pejabat Yang Menandatangani',
            'tingkat_biaya' => 'Tingkat Biaya Perjalanan Dinas',
            'kendaraan' => 'Alat Angkutan yang dipergunakan',
            'created_by' => 'Dibuat oleh',
            'upated_by' => 'Terakhir diperbaharui oleh',
        ];
    }
}
