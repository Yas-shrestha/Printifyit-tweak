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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->string('front_img');
            $table->string('back_img')->nullable();
            $table->string('right_img')->nullable();
            $table->string('left_img')->nullable();
            $table->string('size'); // Size of the variant (e.g., S, M, L)
            $table->string('color'); // Color of the variant (e.g., Red, Blue)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
