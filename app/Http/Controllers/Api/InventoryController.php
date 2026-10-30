<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\InventoryService;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function __construct(protected InventoryService $inventoryService) {}

    public function index()
    {
        return response()->json($this->inventoryService->list());
    }

    public function lowStock()
    {
        return response()->json($this->inventoryService->lowStock());
    }

    public function adjust(Request $request)
    {
        $data = $request->validate([
            'warehouse_id' => ['required', 'uuid', 'exists:warehouses,id'],
            'material_id' => ['required', 'uuid', 'exists:raw_materials,id'],
            'quantity' => ['required', 'numeric'],
        ]);

        $stock = $this->inventoryService->adjust(
            $data['warehouse_id'],
            $data['material_id'],
            (float) $data['quantity']
        );

        return response()->json($stock, 200);
    }
}
