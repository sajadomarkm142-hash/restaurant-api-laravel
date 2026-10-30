<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasUuids;

    protected $table = 'order_items';

    protected $fillable = [
        'order_id',
        'menu_item_id',
        'variant_id',
        'quantity',
        'unit_price',
        'line_total',
        'status',
        'kitchen_notes',
    ];
}
