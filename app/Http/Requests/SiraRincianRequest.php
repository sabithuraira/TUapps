<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SiraRincianRequest extends FormRequest
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
            'kode_mak' => 'required',
            'kode_akun' => 'required',
            'kode_fungsi' => 'required',
            'jenis' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'kode_mak' => 'Kegiatan',
            'kode_akun' => 'MAK',
            'kode_fungsi' => 'Fungsi',
            'jenis' => 'Jenis',
            'path_kak' => 'KAK',
            'path_form_permintaan' => 'Form Permintaan',
            'path_notdin' => 'Nota Dinas',
            'path_undangan' => 'Undangan',
            'path_bukti_pembayaran' => 'Bukti Pembayaran',
            'path_kuitansi' => 'Kuitansi',
            'path_notulen' => 'Notulen',
            'path_daftar_hadir' => 'Daftar Hadir',
            'path_sk' => 'SK',
            'path_st' => 'Surat Tugas',

            'path_spk' => 'Surat Perjanjian Kerja (SPK)',
            'path_bast' => 'BAST',
            'path_rekap_belanja' => 'Daftar Rekapitulasi Belanja',
            'path_laporan' => 'Laporan',
            'path_jadwal' => 'Jadwal Kegiatan',
            'path_drpp' => 'DRPP',
            'path_invoice' => 'Invoice/Nota Pembelian',
            'path_resi_pengiriman' => 'Resi Pengiriman',
            'path_npwp_rekkor' => 'FC NPWP dan Rekening Koran',
            'path_tanda_terima' => 'Tanda Terima',
            'path_cv' => 'Curriculum Vitae (CV)',
            'path_bahan_paparan' => 'Bahan Paparan',
            'path_ba_pembayaran' => 'Berita Acara Pembayaran',
            'path_spd_visum' => 'SPD dan Bukti Visum',
            'path_presensi_uang_makan' => 'Presensi dan Uang Makan',
            'path_rincian_perjadin' => 'Rincian Biaya Perjalanan Dinas',
            'path_bukti_transport' => 'Bukti Transport',
            'path_bukti_inap' => 'Bukti Penginapan',
            'path_lpd' => 'Laporan Perjalanan Dinas',
            'path_rekap_perjadin' => 'Rekap Pembayaran Perjalanan Dinas',
            'path_sp_kendaraan_dinas' => 'Surat Pernyataan Tidak Menggunakan Kendaraan Dinas',
            'path_daftar_rill' => 'Daftar Pengeluaran Rill',
        ];
    }
}
