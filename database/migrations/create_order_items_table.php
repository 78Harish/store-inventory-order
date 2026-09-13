<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id('order_item_id');
            $table->foreignId('order_id')->constrained('orders', 'order_id')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products', 'product_id')->onDelete('cascade');
            $table->integer('order_quantity')->default(1);
            $table->decimal('order_unit_price', 10, 2);
            $table->decimal('order_tax_percentage', 10, 2);
            $table->decimal('order_tax_amount', 10, 2);
            $table->decimal('order_line_total', 10, 2);
            $table->timestamp('order_item_created_at')->useCurrent();
            $table->timestamp('order_item_updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
