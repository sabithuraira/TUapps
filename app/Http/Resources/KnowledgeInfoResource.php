<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class KnowledgeInfoResource extends Resource
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
            'title' => $this->title,
            'content' => $this->content,
            'category' => $this->category,
            'tag' => $this->tag,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at ? $this->created_at->format('Y-m-d H:i:s') : null,
            'updated_at' => $this->updated_at ? $this->updated_at->format('Y-m-d H:i:s') : null,
            'created_by_user' => $this->whenLoaded('createdBy', function () {
                return $this->createdBy ? [
                    'id' => $this->createdBy->id,
                    'name' => $this->createdBy->name,
                ] : null;
            }),
            'updated_by_user' => $this->whenLoaded('updatedBy', function () {
                return $this->updatedBy ? [
                    'id' => $this->updatedBy->id,
                    'name' => $this->updatedBy->name,
                ] : null;
            }),
        ];
    }
}
