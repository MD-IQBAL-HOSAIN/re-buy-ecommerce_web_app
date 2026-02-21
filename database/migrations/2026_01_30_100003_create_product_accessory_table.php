<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Pivot table for Product and Accessory (Many-to-Many)
     */
    public function up(): void
    {
        Schema::create('product_accessory', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->nullable()->constrained('products')->onDelete('cascade');
            $table->foreignId('accessory_id')->nullable()->constrained('accessories')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['product_id', 'accessory_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_accessory');
    }
};
