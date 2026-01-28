<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class DailyStandupResource extends Resource
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
            'pegawai_nip' => $this->pegawai_nip,
            'tim_id' => $this->tim_id,
            'tanggal' => $this->tanggal ? $this->tanggal->format('Y-m-d') : null,
            'isi' => $this->isi,
            'keterangan' => $this->keterangan,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at ? $this->created_at->format('Y-m-d H:i:s') : null,
            'updated_at' => $this->updated_at ? $this->updated_at->format('Y-m-d H:i:s') : null,
            
            // Relationships (when loaded)
            'tim_master' => $this->whenLoaded('timMaster', function () {
                return [
                    'id' => $this->timMaster->id,
                    'nama_tim' => $this->timMaster->nama_tim,
                ];
            }),
            'created_by_user' => $this->whenLoaded('createdBy', function () {
                return [
                    'id' => $this->createdBy->id,
                    'name' => $this->createdBy->name,
                    'nip' => $this->createdBy->nip ?? $this->createdBy->nip_baru ?? null,
                ];
            }),
            'updated_by_user' => $this->whenLoaded('updatedBy', function () {
                return [
                    'id' => $this->updatedBy->id,
                    'name' => $this->updatedBy->name,
                    'nip' => $this->updatedBy->nip ?? $this->updatedBy->nip_baru ?? null,
                ];
            }),
        ];
    }
}
