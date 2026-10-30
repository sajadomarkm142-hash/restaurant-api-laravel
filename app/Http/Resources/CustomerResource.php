<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'full_name' => $this->full_name,
            'phone' => $this->phone,
            'email' => $this->email,
            'customer_type' => $this->customer_type,
            'notes' => $this->notes,
            'is_active' => $this->is_active,
            'addresses' => $this->whenLoaded('addresses'),
        ];
    }
}
