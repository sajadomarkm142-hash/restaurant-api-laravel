<?php

namespace App\Repositories;

use App\Models\WarehouseStock;

class InventoryRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(new WarehouseStock());
    }

    public function getLowStock()
    {
        return WarehouseStock::query()
            ->with(['warehouse', 'material'])
            ->whereRaw('quantity_on_hand <= (SELECT min_alert_qty FROM raw_materials WHERE raw_materials.id = warehouse_stocks.material_id)')
            ->get();
    }

    public function findByWarehouseAndMaterial(string $warehouseId, string $materialId)
    {
        return WarehouseStock::query()
            ->where('warehouse_id', $warehouseId)
            ->where('material_id', $materialId)
            ->first();
    }
}
