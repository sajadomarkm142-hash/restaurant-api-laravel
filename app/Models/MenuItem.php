<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasUuids;

    protected $table = 'menu_items';

    protected $fillable = [
        'category_id',
        'code',
        'name',
        'base_price',
        'prep_time_minutes',
        'is_available',
        'is_featured',
    ];

    public function category()
    {
        return $this->belongsTo(MenuCategory::class, 'category_id');
    }

    public function variants()
    {
        return $this->hasMany(MenuVariant::class, 'menu_item_id');
    }
}
