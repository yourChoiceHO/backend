<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Candidate extends JsonResource
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
            'party_id' => $this->party_id,
            'consituency' => $this->consituency,
            'election_id' => $this->election_id,
            'vote' => $this->vote
        ];
    }
}
