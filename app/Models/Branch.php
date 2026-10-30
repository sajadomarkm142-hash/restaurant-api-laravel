<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasUuids;

    protected $table = 'branches';

    protected $fillable = [
        'code',
        'name',
        'phone',
        'address',
        'tax_id',
        'currency',
        'is_active',
    ];
}
