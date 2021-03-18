<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OpnamePenambahanRequest extends FormRequest
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
            'id_barang' => 'required',
            'bulan'     => 'required|numeric',
            'tahun'     => 'required|numeric',
            'jumlah_tambah'     => 'required|numeric',
            'harga_tambah'     => 'required|numeric',
            'tanggal'     => 'required',
            'nama_penyedia'     => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'id_barang' => 'ID Barang',
            'bulan' => 'Bulan',
            'tahun' => 'Tahun',
            'jumlah_tambah' => 'Jumlah',
            'harga_tambah' => 'Harga',
            'unit_kerja' => 'Unit Kerja',
            'nama_penyedia' => 'Nama Penyedia',
            'tanggal' => 'Tanggal',
            'created_by' => 'Dibuat oleh',
            'updated_by' => 'Terkahir diperbaharui oleh',
            'created_at' => 'Dibuat pada',
            'updated_at' => 'Terakhir diperbaharui pada',
        ];
    }
}
