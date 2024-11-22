<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlanResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'invoice_interval' => $this->invoice_interval,
            'trial_period' => $this->trial_period,
            'trial_interval' => $this->trial_period,
            'is_subscribed' => auth()->user() ? auth()->user()->subscribedTo($this->id) : false,
            'features' => FeatureResource::collection($this->features)
        ];
    }
}
