<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SuratKmRequest extends FormRequest
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
            'nomor_urut' => 'required|max:255',
            'alamat' => 'required',
            'tanggal' => 'required',
            'perihal' => 'required',
        ];
    }

    public function messages()
    {
        return [
            // 'kode.required' => ':attribute tidak boleh kosong',
            // 'kode.unique' => ':attribute sudah ada',
            // 'nama.required' => ':attribute tidak boleh kosong',
        ];
    }


    // $table->string('nomor_urut');
    // $table->string('alamat');
    // $table->date('tanggal');
    // $table->string('nomor')->nullable();
    // $table->string('perihal');
    // $table->string('nomor_petunjuk')->nullable();

    // $table->integer('jenis_surat');

    public function attributes()
    {
        return [
            'nomor_urut' => 'Nomor Urut',
            'alamat' => 'Alamat',
            'tanggal' => 'Tanggal',
            'nomor' => 'Nomor',
            'perihal' => 'Perihal',
            'nomor_petunjuk' => 'Nomor Petunjuk',
            'jenis_surat' => 'Jenis Surat',
        ];
    }
}
