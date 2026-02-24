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
        Schema::create('sell_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('language_id')->nullable()->constrained('languages')->onDelete('cascade');
            $table->foreignId('buy_subcategory_id')->nullable()->constrained('buy_subcategories')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('short_name')->nullable();
            $table->string('slug')->nullable();
            $table->string('image')->nullable();
            $table->string('storage')->nullable();
            $table->string('color')->nullable();
            $table->string('model')->nullable();
            $table->string('ean')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sell_products');
    }
};
