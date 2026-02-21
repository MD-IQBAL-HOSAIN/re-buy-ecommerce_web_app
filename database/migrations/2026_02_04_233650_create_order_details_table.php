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
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
             $table->foreignId('color_id')->nullable()->constrained('colors')->onDelete('set null');
            $table->foreignId('storage_id')->nullable()->constrained('storages')->onDelete('set null');
            $table->foreignId('accessory_id')->nullable()->constrained('accessories')->onDelete('set null');
            $table->json('protection_services')->nullable();
            $table->decimal('accessory_price', 10, 2)->default(0);
            $table->decimal('protection_services_price', 10, 2)->default(0);
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2);       // unit price
            $table->decimal('total_price', 10, 2); // qty * price
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
