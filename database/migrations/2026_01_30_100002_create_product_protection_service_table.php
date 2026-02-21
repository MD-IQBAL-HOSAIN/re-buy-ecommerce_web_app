<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Pivot table for Product and Protection Service (Many-to-Many)
     */
    public function up(): void
    {
        Schema::create('product_protection_service', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->nullable()->constrained('products')->onDelete('cascade');
            $table->foreignId('protection_service_id')->nullable()->constrained('protection_services')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['product_id', 'protection_service_id'], 'product_protection_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_protection_service');
    }
};
