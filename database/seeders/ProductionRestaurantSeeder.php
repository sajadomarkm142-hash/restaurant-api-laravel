<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Customer;
use App\Models\MenuCategory;
use App\Models\MenuItem;
use App\Models\MeasurementUnit;
use App\Models\PurchaseOrder;
use App\Models\RawMaterial;
use App\Models\Supplier;
use App\Models\Warehouse;
use App\Models\WarehouseStock;
use Illuminate\Database\Seeder;

class ProductionRestaurantSeeder extends Seeder
{
    public function run(): void
    {
        $branch = Branch::firstOrCreate(
            ['code' => 'BR-001'],
            [
                'name' => 'Main Restaurant',
                'phone' => '+93700000001',
                'address' => 'Kabul, Afghanistan',
                'tax_id' => 'AF-1001',
                'currency' => 'AFN',
                'is_active' => true,
            ]
        );

        $secondBranch = Branch::firstOrCreate(
            ['code' => 'BR-002'],
            [
                'name' => 'North Branch',
                'phone' => '+93700000002',
                'address' => 'Mazar, Afghanistan',
                'tax_id' => 'AF-1002',
                'currency' => 'AFN',
                'is_active' => true,
            ]
        );

        $kg = MeasurementUnit::firstOrCreate(['name' => 'Kilogram', 'symbol' => 'kg']);
        $g = MeasurementUnit::firstOrCreate(['name' => 'Gram', 'symbol' => 'g']);
        $l = MeasurementUnit::firstOrCreate(['name' => 'Liter', 'symbol' => 'L']);
        $pcs = MeasurementUnit::firstOrCreate(['name' => 'Piece', 'symbol' => 'pcs']);

        $warehouse = Warehouse::firstOrCreate([
            'branch_id' => $branch->id,
            'name' => 'Main Warehouse',
            'location' => 'Back Kitchen',
            'is_active' => true,
        ]);

        $materials = [
            ['code' => 'RM-001', 'name' => 'Rice', 'unit_id' => $kg->id, 'min_alert_qty' => 12.000, 'standard_cost' => 45.00],
            ['code' => 'RM-002', 'name' => 'Chicken', 'unit_id' => $kg->id, 'min_alert_qty' => 15.000, 'standard_cost' => 120.00],
            ['code' => 'RM-003', 'name' => 'Tomato', 'unit_id' => $g->id, 'min_alert_qty' => 2500.000, 'standard_cost' => 12.00],
            ['code' => 'RM-004', 'name' => 'Oil', 'unit_id' => $l->id, 'min_alert_qty' => 20.000, 'standard_cost' => 80.00],
            ['code' => 'RM-005', 'name' => 'Bread', 'unit_id' => $pcs->id, 'min_alert_qty' => 30.000, 'standard_cost' => 16.00],
        ];

        foreach ($materials as $item) {
            $material = RawMaterial::firstOrCreate(['code' => $item['code']], [
                'name' => $item['name'],
                'unit_id' => $item['unit_id'],
                'min_alert_qty' => $item['min_alert_qty'],
                'standard_cost' => $item['standard_cost'],
                'is_active' => true,
            ]);

            WarehouseStock::firstOrCreate(
                ['warehouse_id' => $warehouse->id, 'material_id' => $material->id],
                ['quantity_on_hand' => 100.000, 'last_updated_at' => now()]
            );
        }

        $supplier = Supplier::firstOrCreate(
            ['name' => 'Afghan Fresh Supply'],
            [
                'branch_id' => $branch->id,
                'contact_person' => 'Ali Haidari',
                'phone' => '+93700000011',
                'email' => 'supply@afghanfood.af',
                'address' => 'Kabul',
                'tax_id' => 'AF-2001',
                'is_active' => true,
            ]
        );

        PurchaseOrder::firstOrCreate(
            ['purchase_order_number' => 'PO-1001'],
            [
                'branch_id' => $branch->id,
                'supplier_id' => $supplier->id,
                'warehouse_id' => $warehouse->id,
                'order_date' => now()->toDateString(),
                'expected_delivery' => now()->addDays(4)->toDateString(),
                'status' => 'OPEN',
                'created_by' => \App\Models\User::first()->id,
            ]
        );

        $category1 = MenuCategory::firstOrCreate(['name' => 'Rice Dishes'], ['sort_order' => 1, 'is_active' => true]);
        $category2 = MenuCategory::firstOrCreate(['name' => 'Grill'], ['sort_order' => 2, 'is_active' => true]);
        $category3 = MenuCategory::firstOrCreate(['name' => 'Soups'], ['sort_order' => 3, 'is_active' => true]);

        MenuItem::firstOrCreate(['code' => 'MI-001'], [
            'category_id' => $category1->id,
            'name' => 'Kabuli Rice',
            'base_price' => 180.00,
            'prep_time_minutes' => 20,
            'is_available' => true,
            'is_featured' => true,
        ]);

        MenuItem::firstOrCreate(['code' => 'MI-002'], [
            'category_id' => $category2->id,
            'name' => 'Grilled Chicken',
            'base_price' => 260.00,
            'prep_time_minutes' => 25,
            'is_available' => true,
            'is_featured' => true,
        ]);

        MenuItem::firstOrCreate(['code' => 'MI-003'], [
            'category_id' => $category3->id,
            'name' => 'Tomato Soup',
            'base_price' => 90.00,
            'prep_time_minutes' => 10,
            'is_available' => true,
            'is_featured' => false,
        ]);

        for ($i = 1; $i <= 15; $i++) {
            Customer::firstOrCreate(
                ['email' => 'customer' . $i . '@restaurant.local'],
                [
                    'branch_id' => $branch->id,
                    'full_name' => 'Customer ' . $i,
                    'phone' => '+937' . str_pad((string) $i, 8, '0', STR_PAD_LEFT),
                    'customer_type' => $i % 3 === 0 ? 'VIP' : 'REGULAR',
                    'notes' => 'Sample customer data',
                    'is_active' => true,
                ]
            );
        }
    }
}
