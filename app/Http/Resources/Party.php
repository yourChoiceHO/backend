<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Party extends JsonResource
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
            'name' => $this->name,
            'text' => $this->text,
            'consituency' => $this->consituency,
            'election_id' => $this->election_id,
            'vote' => $this->vote,
        ];
    }
}
