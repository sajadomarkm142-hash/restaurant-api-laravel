<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class MenuCategory extends Model
{
    use HasUuids;

    protected $table = 'menu_categories';

    protected $fillable = [
        'name',
        'sort_order',
        'is_active',
    ];
}
