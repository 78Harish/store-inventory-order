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
        Schema::create('orders', function (Blueprint $table) {
            $table->id('order_id');
            $table->foreignId('order_customer_id')->constrained('customers', 'customer_id')->onDelete('cascade');
            $table->decimal('order_subtotal', 10, 2);
            $table->decimal('order_tax', 10, 2);
            $table->decimal('order_grand_total', 10, 2);
            $table->timestamp('order_created_at')->useCurrent();
            $table->timestamp('order_updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
