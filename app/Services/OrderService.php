<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Repositories\OrderRepository;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function __construct(protected OrderRepository $repository) {}

    public function list()
    {
        return $this->repository->allDetailed();
    }

    public function create(array $data): Order
    {
        return DB::transaction(function () use ($data) {
            $order = Order::create([
                'branch_id' => $data['branch_id'],
                'table_id' => $data['table_id'] ?? null,
                'customer_id' => $data['customer_id'] ?? null,
                'server_id' => $data['server_id'] ?? null,
                'order_number' => 'ORD-' . now()->format('Ymd') . '-' . strtoupper(\Str::random(6)),
                'order_type' => $data['order_type'] ?? 'DINE_IN',
                'status' => 'OPEN',
                'notes' => $data['notes'] ?? null,
                'subtotal_amount' => 0,
                'discount_amount' => 0,
                'tax_amount' => 0,
                'service_charge' => 0,
                'net_payable' => 0,
            ]);

            $subtotal = 0;

            foreach ($data['items'] as $item) {
                $menuItem = \App\Models\MenuItem::findOrFail($item['menu_item_id']);
                $quantity = (float) $item['quantity'];
                $lineTotal = $quantity * (float) $menuItem->base_price;

                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_item_id' => $menuItem->id,
                    'variant_id' => $item['variant_id'] ?? null,
                    'quantity' => $quantity,
                    'unit_price' => $menuItem->base_price,
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

            return $order->load('items');
        });
    }
}
