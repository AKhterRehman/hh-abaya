<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name')->nullable();
            $table->string('slug')->nullable()->unique();
            $table->string('sku')->nullable()->unique();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->string('fabric')->nullable();
            $table->decimal('regular_price', 10, 2)->nullable()->default(0);
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->integer('stock')->nullable()->default(10);
            $table->boolean('is_featured')->nullable()->default(false);
            $table->boolean('is_new')->nullable()->default(false);
            $table->boolean('is_bestseller')->nullable()->default(false);
            $table->string('status')->nullable()->default('active');
            $table->string('primary_image')->nullable();
            $table->text('gallery_images')->nullable();
            $table->text('sizes')->nullable();
            $table->text('lengths')->nullable();
            $table->text('colors')->nullable();
            $table->decimal('rating', 3, 2)->nullable()->default(5.00);
            $table->integer('reviews_count')->nullable()->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
