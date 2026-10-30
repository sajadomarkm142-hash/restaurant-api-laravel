<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'order_number' => $this->order_number,
            'status' => $this->status,
            'order_type' => $this->order_type,
            'subtotal_amount' => $this->subtotal_amount,
            'tax_amount' => $this->tax_amount,
            'service_charge' => $this->service_charge,
            'net_payable' => $this->net_payable,
            'items' => $this->whenLoaded('items'),
            'payments' => $this->whenLoaded('payments'),
        ];
    }
}
