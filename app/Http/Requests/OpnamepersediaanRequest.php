<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OpnamepersediaanRequest extends FormRequest
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
            'saldo_awal'     => 'required|numeric',
            'harga_awal'     => 'required|numeric',
            'saldo_tambah'     => 'required|numeric',
            'harga_tambah'     => 'required|numeric',
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
            'id_barang' => 'ID Barang',
            'nama_barang' => 'Nama Barang',
            'bulan' => 'Bulan',
            'tahun' => 'Tahun',
            'saldo_awal' => 'Saldo Awal',
            'harga_awal' => 'Harga Awal',
            'saldo_tambah' => 'Saldo Tambah',
            'harga_tambah' => 'Harga Tambah',
            'created_by' => 'Dibuat oleh',
            'updated_by' => 'Terkahir diperbaharui oleh',
            'created_at' => 'Dibuat pada',
            'updated_at' => 'Terakhir diperbaharui pada',
        ];
    }
}
