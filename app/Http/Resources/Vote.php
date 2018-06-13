<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Vote extends JsonResource
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
            'voter_id' => $this->voter_id,
            'election_id' => $this->election_id,
            'first_vote' => $this->first_vote,
            'second_vote' => $this->second_vote,
            'valid' => $this->valid
        ];
    }
}
