<?php

namespace App\Services;

use App\Models\WarehouseStock;
use App\Repositories\InventoryRepository;

class InventoryService
{
    public function __construct(protected InventoryRepository $repository) {}

    public function list()
    {
        return WarehouseStock::with(['warehouse', 'material'])->get();
    }

    public function lowStock()
    {
        return $this->repository->getLowStock();
    }

    public function adjust(string $warehouseId, string $materialId, float $quantity): WarehouseStock
    {
        $stock = $this->repository->findByWarehouseAndMaterial($warehouseId, $materialId);

        if (!$stock) {
            $stock = WarehouseStock::create([
                'warehouse_id' => $warehouseId,
                'material_id' => $materialId,
                'quantity_on_hand' => 0,
            ]);
        }

        $stock->quantity_on_hand += $quantity;
        $stock->last_updated_at = now();
        $stock->save();

        return $stock;
    }
}
