<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Pivot table for Product and Color (Many-to-Many)
     */
    public function up(): void
    {
        Schema::create('product_color', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->nullable()->constrained('products')->onDelete('cascade');
            $table->foreignId('color_id')->nullable()->constrained('colors')->onDelete('cascade');
            $table->decimal('extra_price', 10, 2)->default(0)->comment('Additional price for this color option');
            $table->integer('stock')->default(0)->comment('Stock for this color variant');
            $table->timestamps();

            $table->unique(['product_id', 'color_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_color');
    }
};
