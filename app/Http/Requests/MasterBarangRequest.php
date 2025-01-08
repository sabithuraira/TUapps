<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MasterBarangRequest extends FormRequest
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
            'nama_barang' => 'required',
            // 'unit_kerja' => 'required',
            'harga_satuan' => 'required|numeric',
            'satuan' => 'required',
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
            'nama_barang' => 'Nama Barang',
            'kode_barang' => 'Kode Barang',
            'unit_kerja' => 'Unit Kerja',
            'harga_satuan' => 'Harga Satuan',
            'satuan' => 'Satuan',
            'created_by' => 'Dibuat oleh',
            'updated_by' => 'Terkahir diperbaharui oleh',
            'created_at' => 'Dibuat pada',
            'updated_at' => 'Terakhir diperbaharui pada',
        ];
    }
}
