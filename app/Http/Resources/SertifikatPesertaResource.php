<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class SertifikatPesertaResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'sertifikat_induk_id' => $this->sertifikat_induk_id,
            'nama_peserta' => $this->nama_peserta,
            'nomor_urut' => $this->nomor_urut,
            'nomor_sertifikat' => $this->nomor_sertifikat,
            'created_at' => $this->created_at ? $this->created_at->format('Y-m-d H:i:s') : null,
            'updated_at' => $this->updated_at ? $this->updated_at->format('Y-m-d H:i:s') : null,
            'induk' => $this->whenLoaded('induk', function () {
                return new SertifikatIndukResource($this->induk);
            }),
        ];
    }
}
