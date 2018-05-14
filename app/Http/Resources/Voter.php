<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Voter extends JsonResource
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
            'last_name' => $this->last_name,
            'first_name' => $this->first_name,
            'hash' => $this->hash,
            'constituency' => $this->constituency
        ];
    }
}
