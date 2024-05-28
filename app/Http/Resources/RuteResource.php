<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RuteResource extends JsonResource
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
            'tujuan' => $this->tujuan,
            'start' => $this->start,
            'end' => $this->end,
            'harga' => $this->harga,
            'waktu' => $this->jam,
            'transportasi_id' => $this->whenLoaded('trans'),
            "message" => "berhsail"
        ];
    }
}
