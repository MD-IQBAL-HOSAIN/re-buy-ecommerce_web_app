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
        Schema::create('c_m_s', function (Blueprint $table) {
            $table->id();
            $table->foreignId('language_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->string('button_text_one')->nullable();
            $table->string('button_text_two')->nullable();
            $table->string('checkout')->nullable();
            $table->string('email_text')->nullable();
            $table->string('phone')->nullable();
            $table->string('total')->nullable();
            $table->string('continue')->nullable();
            $table->string('back')->nullable();
            $table->string('place_order')->nullable();
            $table->string('add_to_cart')->nullable();
            $table->string('buy_now')->nullable();
            $table->string('shipping')->nullable();
            $table->string('payment')->nullable();
            $table->string('review')->nullable();
            $table->string('return')->nullable();
            $table->string('order_summary')->nullable();
            $table->string('customer_details')->nullable();
            $table->string('subtotal')->nullable();
            $table->string('products')->nullable();
            $table->string('contact')->nullable();
            $table->string('city')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('country')->nullable();
            $table->text('description')->nullable();
            $table->text('content')->nullable();
            $table->string('image')->nullable();
            $table->string('image_two')->nullable();
            $table->string('image_three')->nullable();
            $table->string('image_four')->nullable();
            $table->string('image_five')->nullable();
            $table->string('slug')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('c_m_s');
    }
};
