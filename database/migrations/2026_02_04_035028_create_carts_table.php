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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('customer_information_id')->nullable()->constrained('customer_information')->onDelete('set null');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('color_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('storage_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('accessory_id')->nullable()->constrained()->onDelete('set null');
            $table->json('protection_services')->nullable();
            $table->integer('quantity')->default(1);
            $table->decimal('product_price', 10, 2);
            $table->decimal('accessory_price', 10, 2)->nullable();
            $table->decimal('protection_services_price', 10, 2)->nullable();
            $table->decimal('total_price', 10, 2);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
