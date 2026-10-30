<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;

class DashboardController extends Controller
{
    public function summary()
    {
        return response()->json([
            'total_orders' => Order::count(),
            'today_revenue' => (float) Order::whereDate('created_at', today())->sum('net_payable'),
            'open_orders' => Order::where('status', 'OPEN')->count(),
            'completed_orders' => Order::where('status', 'COMPLETED')->count(),
        ]);
    }
}
