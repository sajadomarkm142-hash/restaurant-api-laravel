<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasUuids;

    protected $table = 'orders';

    protected $fillable = [
        'branch_id',
        'table_id',
        'customer_id',
        'server_id',
        'order_number',
        'order_type',
        'status',
        'subtotal_amount',
        'discount_amount',
        'tax_amount',
        'service_charge',
        'net_payable',
        'notes',
        'completed_at',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }
}
