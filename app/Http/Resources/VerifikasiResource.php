<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VerifikasiResource extends JsonResource
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
            'nik' => $this->id,
            'penumpang_id' => $this->penumpang_id,
            'penumpang_name' => $this->penumpang->name,
            'telepon' =>$this->telepon,
            'transportasi_id' => $this->transportasi_id,
            'transportasi_name' => $this->transportasi->name,
            'transportasi_kode' => $this->transportasi_id->kode,
            'nomor_kursi' =>$this->nomor_kursi,
            'sisa_kusi' =>$this->sisa_kursi
        ];
    }
}
