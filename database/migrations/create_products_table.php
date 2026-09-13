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
        Schema::create('products', function (Blueprint $table) {
            $table->id('product_id');
            $table->string('product_code')->unique();
            $table->string('product_name');
            $table->decimal('product_price', 10, 2);
            $table->decimal('product_tax_percent', 10, 2);
            $table->integer('product_stock_on_hand')->default(0);
            $table->integer('product_threshold')->default(0);
            $table->timestamp('product_created_at')->useCurrent();
            $table->timestamp('product_updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
