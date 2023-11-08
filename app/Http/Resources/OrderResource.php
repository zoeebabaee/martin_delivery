<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'source_mobile' => $this->source_mobile,
            'source_name' => $this->source_name,
            'source_address' => $this->source_address,
            'source_latitude' => $this->source_latitude,
            'source_longitude' => $this->source_longitude,

            'destination_mobile' => $this->destination_mobile,
            'destination_name' => $this->destination_name,
            'destination_address' => $this->destination_address,
            'destination_latitude' => $this->destination_latitude,
            'destination_longitude' => $this->destination_longitude,

        ];


    }
}
