<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'branch_id' => ['required', 'uuid', 'exists:branches,id'],
            'table_id' => ['nullable', 'uuid', 'exists:dining_tables,id'],
            'customer_id' => ['nullable', 'uuid', 'exists:customers,id'],
            'server_id' => ['nullable', 'uuid', 'exists:users,id'],
            'order_type' => ['nullable', 'string', 'in:DINE_IN,TAKEAWAY,DELIVERY'],
            'notes' => ['nullable', 'string'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.menu_item_id' => ['required', 'uuid', 'exists:menu_items,id'],
            'items.*.variant_id' => ['nullable', 'uuid', 'exists:menu_variants,id'],
            'items.*.quantity' => ['required', 'numeric', 'min:1'],
            'items.*.kitchen_notes' => ['nullable', 'string'],
        ];
    }
}
