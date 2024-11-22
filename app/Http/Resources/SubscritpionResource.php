<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscritpionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'main' => $this->name,
            'trial_ends_at' => $this->trial_ends_at,
            'starts_at' => $this->starts_at,
            'ends_at' => $this->ends_at,
            'cancels_at' => $this->cancels_at,
            'canceled_at' => $this->canceled_at
        ];
    }
}
