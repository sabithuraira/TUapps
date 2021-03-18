<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Database\Eloquent\Model;


class ViconRequest extends FormRequest
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
            'tanggal'=>'required',
            'keperluan'=>'required',
            'ketua'=> 'required',
            'jamawalguna'=>'required',
            'jamakhirguna'=>'required',
            'status'=>'required',
            //
        ];
    }
    public function attributes()
    {
        return [
            'tanggal'=>'Tanggal Pelaksanaan',
            'keperluan'=>'Penggunaan',
            'ketua'=>'Penanggung Jawab Kegiatan',
            'jamawalguna'=>'Waktu Mulai',
            'jamakhirguna'=>'Waktu Selesai',
            'status'=>'Status',
            'created_by' => 'Dibuat oleh',
            'updated_by' => 'Terakhir diperbaharui oleh',
            'created_at' => 'Dibuat pada',
            'updated_at' => 'Terakhir diperbaharui pada',

        ];
    }
}
