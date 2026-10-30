<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return response()->json(Order::with('items')->get());
    }

    public function show($id)
    {
        return response()->json(Order::with('items')->findOrFail($id));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
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
        ]);

        $order = Order::create([
            'branch_id' => $validated['branch_id'],
            'table_id' => $validated['table_id'] ?? null,
            'customer_id' => $validated['customer_id'] ?? null,
            'server_id' => $validated['server_id'] ?? null,
            'order_number' => 'ORD-' . now()->format('Ymd') . '-' . strtoupper(\Str::random(6)),
            'order_type' => $validated['order_type'] ?? 'DINE_IN',
            'status' => 'OPEN',
            'notes' => $validated['notes'] ?? null,
            'subtotal_amount' => 0,
            'discount_amount' => 0,
            'tax_amount' => 0,
            'service_charge' => 0,
            'net_payable' => 0,
        ]);

        $subtotal = 0;

        foreach ($validated['items'] as $item) {
            $menuItem = \App\Models\MenuItem::findOrFail($item['menu_item_id']);
            $quantity = (float) $item['quantity'];
            $unitPrice = (float) $menuItem->base_price;
            $lineTotal = $quantity * $unitPrice;

            OrderItem::create([
                'order_id' => $order->id,
                'menu_item_id' => $menuItem->id,
                'variant_id' => $item['variant_id'] ?? null,
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'line_total' => $lineTotal,
                'status' => 'PENDING',
                'kitchen_notes' => $item['kitchen_notes'] ?? null,
            ]);

            $subtotal += $lineTotal;
        }

        $tax = $subtotal * 0.10;
        $serviceCharge = $subtotal * 0.05;
        $net = $subtotal + $tax + $serviceCharge;

        $order->update([
            'subtotal_amount' => $subtotal,
            'tax_amount' => $tax,
            'service_charge' => $serviceCharge,
            'net_payable' => $net,
        ]);

        return response()->json($order->load('items'), 201);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => ['required', 'string', 'in:OPEN,COOKING,READY,SERVED,COMPLETED,CANCELLED'],
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return response()->json($order);
    }
}
