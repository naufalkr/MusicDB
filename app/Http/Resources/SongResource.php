<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SongResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'artist' => new SingerResource($this->artist),  // Relasi ke tabel singer
            'album' => new AlbumResource($this->albm),     // Relasi ke tabel album
            'year' => $this->year,
            'duration' => $this->duration,
            'record_label' => new RecordLabelResource($this->rl), // Relasi ke tabel recordlabel
            'genre' => $this->category,
            'popularity' => $this->description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
