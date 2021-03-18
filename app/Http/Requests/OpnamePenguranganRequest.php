<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OpnamePenguranganRequest extends FormRequest
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
            'jumlah_kurang'     => 'required|numeric',
            'harga_kurang'     => 'required|numeric',
            'unit_kerja'     => 'required|numeric',
            'tanggal'     => 'required',
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
            'bulan' => 'Bulan',
            'tahun' => 'Tahun',
            'jumlah_kurang' => 'Jumlah',
            'harga_kurang' => 'Harga',
            'unit_kerja' => 'Unit Kerja',
            'tanggal' => 'Tanggal',
            'created_by' => 'Dibuat oleh',
            'updated_by' => 'Terkahir diperbaharui oleh',
            'created_at' => 'Dibuat pada',
            'updated_at' => 'Terakhir diperbaharui pada',
        ];
    }
}
