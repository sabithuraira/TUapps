<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class SertifikatIndukResource extends Resource
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
            'kegiatan' => $this->kegiatan,
            'deskripsi' => $this->deskripsi,
            'tanggal' => $this->tanggal ? $this->tanggal->format('Y-m-d') : null,
            'kode_satker' => $this->kode_satker,
            'klasifikasi_arsip' => $this->klasifikasi_arsip,
            'nomor_urut_start' => $this->nomor_urut_start,
            'nomor_urut_end' => $this->nomor_urut_end,
            'created_at' => $this->created_at ? $this->created_at->format('Y-m-d H:i:s') : null,
            'updated_at' => $this->updated_at ? $this->updated_at->format('Y-m-d H:i:s') : null,
            'peserta' => SertifikatPesertaResource::collection($this->whenLoaded('peserta')),
        ];
    }
}
