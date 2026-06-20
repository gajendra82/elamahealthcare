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
            $table->string('category')->nullable();
            $table->text('product_name');
            $table->text('composition')->nullable();
            $table->string('dosage')->nullable();
            $table->string('packaging')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('slug', 512)->unique();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->string('format')->nullable();
            $table->timestamps();

            $table->index(['status', 'category_id']);
            $table->index('product_name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
