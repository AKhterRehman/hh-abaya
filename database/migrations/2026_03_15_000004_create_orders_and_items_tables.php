<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->nullable()->unique();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('customer_name')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('customer_phone')->nullable();
            $table->text('shipping_address')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('payment_method')->nullable()->default('cod');
            $table->string('payment_status')->nullable()->default('pending');
            $table->string('order_status')->nullable()->default('pending');
            $table->decimal('subtotal', 10, 2)->nullable()->default(0);
            $table->decimal('shipping_fee', 10, 2)->nullable()->default(0);
            $table->decimal('discount', 10, 2)->nullable()->default(0);
            $table->string('coupon_code')->nullable();
            $table->decimal('total', 10, 2)->nullable()->default(0);
            $table->text('order_notes')->nullable();
            $table->string('courier_name')->nullable();
            $table->string('tracking_number')->nullable();
            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->string('product_name')->nullable();
            $table->string('product_image')->nullable();
            $table->decimal('price', 10, 2)->nullable()->default(0);
            $table->integer('quantity')->nullable()->default(1);
            $table->string('size')->nullable();
            $table->string('length')->nullable();
            $table->string('color')->nullable();
            $table->decimal('total', 10, 2)->nullable()->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
