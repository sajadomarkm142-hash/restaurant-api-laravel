<?php

namespace App\Repositories;

use App\Models\Order;

class OrderRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(new Order());
    }

    public function allDetailed()
    {
        return Order::with(['items.menuItem', 'payments'])->get();
    }

    public function byIdDetailed(string $id)
    {
        return Order::with(['items.menuItem', 'payments'])->findOrFail($id);
    }
}
