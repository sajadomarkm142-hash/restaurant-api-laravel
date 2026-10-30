<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class MenuVariant extends Model
{
    use HasUuids;

    protected $table = 'menu_variants';

    protected $fillable = [
        'menu_item_id',
        'name',
        'price_override',
        'is_active',
    ];
}
