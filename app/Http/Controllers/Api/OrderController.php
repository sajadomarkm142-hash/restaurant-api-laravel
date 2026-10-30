<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\OrderResource;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(protected OrderService $orderService) {}

    public function index()
    {
        return OrderResource::collection($this->orderService->list());
    }

    public function store(StoreOrderRequest $request)
    {
        $order = $this->orderService->create($request->validated());

        return new OrderResource($order->load('items'));
    }

    public function show(string $id)
    {
        return new OrderResource(\App\Models\Order::with(['items', 'payments'])->findOrFail($id));
    }

    public function updateStatus(Request $request, string $id)
    {
        $request->validate([
            'status' => ['required', 'string', 'in:OPEN,COOKING,READY,SERVED,COMPLETED,CANCELLED'],
        ]);

        $order = \App\Models\Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return new OrderResource($order->load(['items', 'payments']));
    }
}
