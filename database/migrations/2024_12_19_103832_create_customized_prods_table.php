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
        Schema::create('customized_prods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->nullable();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreignId('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // Customization images for different parts of the product
            $table->string('color')->nullable();
            $table->string('size')->nullable();
            $table->json('views'); // Canvas data
            $table->decimal('customization_charge', 10, 2)->default('200'); // Canvas data
            $table->string('status')->default('pending'); // Status of the customization (e.g., pending, approved, completed)

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customized_prods');
    }
};
