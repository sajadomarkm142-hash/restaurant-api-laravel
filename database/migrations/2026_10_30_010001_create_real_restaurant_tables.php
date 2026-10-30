<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('branch_id')->nullable()->constrained('branches')->nullOnDelete();
            $table->string('full_name', 120);
            $table->string('phone', 30)->nullable();
            $table->string('email', 120)->nullable();
            $table->string('customer_type', 30)->default('REGULAR');
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('customer_addresses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->text('address_line');
            $table->string('city', 80)->nullable();
            $table->string('district', 80)->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });

        Schema::create('dining_areas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('branch_id')->constrained('branches')->restrictOnDelete();
            $table->string('name', 80);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('dining_tables', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('area_id')->constrained('dining_areas')->cascadeOnDelete();
            $table->string('table_number', 20);
            $table->integer('capacity')->default(4);
            $table->string('status', 20)->default('VACANT');
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('reservations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('branch_id')->constrained('branches')->restrictOnDelete();
            $table->foreignUuid('table_id')->constrained('dining_tables')->restrictOnDelete();
            $table->foreignUuid('customer_id')->nullable()->constrained('customers')->nullOnDelete();
            $table->string('reservation_code', 40)->unique();
            $table->timestamp('reservation_time');
            $table->integer('guest_count')->default(1);
            $table->string('status', 20)->default('PENDING');
            $table->string('contact_name', 80)->nullable();
            $table->string('contact_phone', 30)->nullable();
            $table->text('notes')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('measurement_units', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 50)->unique();
            $table->string('symbol', 20)->unique();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('warehouses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('branch_id')->constrained('branches')->restrictOnDelete();
            $table->string('name', 100);
            $table->string('location', 200)->nullable();
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('raw_materials', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code', 50)->unique();
            $table->string('name', 150);
            $table->foreignUuid('unit_id')->constrained('measurement_units')->restrictOnDelete();
            $table->decimal('min_alert_qty', 12, 3)->default(5.000);
            $table->decimal('standard_cost', 14, 2)->default(0.00);
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('warehouse_stocks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('warehouse_id')->constrained('warehouses')->cascadeOnDelete();
            $table->foreignUuid('material_id')->constrained('raw_materials')->restrictOnDelete();
            $table->decimal('quantity_on_hand', 12, 3)->default(0.000);
            $table->timestamp('last_updated_at')->useCurrent();
            $table->softDeletes();
            $table->timestamps();
            $table->unique(['warehouse_id', 'material_id']);
        });

        Schema::create('suppliers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('branch_id')->nullable()->constrained('branches')->nullOnDelete();
            $table->string('name', 150);
            $table->string('contact_person', 80)->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('email', 120)->nullable();
            $table->text('address')->nullable();
            $table->string('tax_id', 50)->nullable();
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('branch_id')->constrained('branches')->restrictOnDelete();
            $table->foreignUuid('supplier_id')->constrained('suppliers')->restrictOnDelete();
            $table->foreignUuid('warehouse_id')->constrained('warehouses')->restrictOnDelete();
            $table->string('purchase_order_number', 40)->unique();
            $table->date('order_date')->useCurrent();
            $table->date('expected_delivery')->nullable();
            $table->string('status', 25)->default('DRAFT');
            $table->text('notes')->nullable();
            $table->foreignUuid('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('purchase_order_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('purchase_order_id')->constrained('purchase_orders')->cascadeOnDelete();
            $table->foreignUuid('material_id')->constrained('raw_materials')->restrictOnDelete();
            $table->decimal('quantity', 12, 3);
            $table->decimal('unit_cost', 14, 2);
            $table->decimal('received_qty', 12, 3)->default(0);
            $table->timestamps();
        });

        Schema::create('sales_orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('order_number', 32)->unique();
            $table->foreignUuid('branch_id')->constrained('branches')->restrictOnDelete();
            $table->foreignUuid('shift_id')->nullable()->constrained('pos_shifts')->nullOnDelete();
            $table->foreignUuid('table_id')->nullable()->constrained('dining_tables')->nullOnDelete();
            $table->foreignUuid('server_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('order_type', 20)->default('DINE_IN');
            $table->string('status', 20)->default('OPEN');
            $table->decimal('subtotal_amount', 14, 2)->default(0);
            $table->decimal('discount_amount', 14, 2)->default(0);
            $table->decimal('tax_amount', 14, 2)->default(0);
            $table->decimal('service_charge', 14, 2)->default(0);
            $table->decimal('net_payable', 14, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('sales_order_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('order_id')->constrained('sales_orders')->cascadeOnDelete();
            $table->foreignUuid('menu_item_id')->constrained('menu_items')->restrictOnDelete();
            $table->foreignUuid('variant_id')->nullable()->constrained('menu_variants')->nullOnDelete();
            $table->decimal('quantity', 8, 2)->default(1);
            $table->decimal('unit_price', 12, 2);
            $table->decimal('line_total', 14, 2);
            $table->text('kitchen_notes')->nullable();
            $table->timestamps();
        });

        Schema::create('order_payments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('order_id')->constrained('sales_orders')->cascadeOnDelete();
            $table->foreignUuid('shift_id')->nullable()->constrained('pos_shifts')->nullOnDelete();
            $table->string('payment_method', 20);
            $table->decimal('amount', 14, 2);
            $table->timestamp('paid_at')->useCurrent();
            $table->timestamps();
        });

        Schema::create('chart_of_accounts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code', 30)->unique();
            $table->string('name', 150);
            $table->string('nature', 10);
            $table->string('category', 20);
            $table->foreignUuid('parent_id')->nullable()->constrained('chart_of_accounts')->nullOnDelete();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('journal_vouchers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('branch_id')->constrained('branches')->restrictOnDelete();
            $table->string('voucher_no', 30);
            $table->date('voucher_date');
            $table->string('voucher_type', 50);
            $table->string('reference_type', 50)->nullable();
            $table->string('reference_id', 50)->nullable();
            $table->text('memo')->nullable();
            $table->decimal('total_debit', 14, 2)->default(0);
            $table->decimal('total_credit', 14, 2)->default(0);
            $table->foreignUuid('created_by')->constrained('users')->restrictOnDelete();
            $table->timestamps();
            $table->unique(['branch_id', 'voucher_no']);
        });

        Schema::create('journal_lines', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('voucher_id')->constrained('journal_vouchers')->cascadeOnDelete();
            $table->foreignUuid('account_id')->constrained('chart_of_accounts')->restrictOnDelete();
            $table->decimal('debit', 14, 2)->default(0);
            $table->decimal('credit', 14, 2)->default(0);
            $table->text('line_memo')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('journal_lines');
        Schema::dropIfExists('journal_vouchers');
        Schema::dropIfExists('chart_of_accounts');
        Schema::dropIfExists('order_payments');
        Schema::dropIfExists('sales_order_items');
        Schema::dropIfExists('sales_orders');
        Schema::dropIfExists('purchase_order_items');
        Schema::dropIfExists('purchase_orders');
        Schema::dropIfExists('suppliers');
        Schema::dropIfExists('warehouse_stocks');
        Schema::dropIfExists('raw_materials');
        Schema::dropIfExists('warehouses');
        Schema::dropIfExists('measurement_units');
        Schema::dropIfExists('reservations');
        Schema::dropIfExists('dining_tables');
        Schema::dropIfExists('dining_areas');
        Schema::dropIfExists('customer_addresses');
        Schema::dropIfExists('customers');
    }
};
