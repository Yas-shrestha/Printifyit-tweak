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
            $table->string('img')->nullable();
            $table->longText('suggestion')->nullable();
            $table->string('color')->nullable();
            $table->string('size');

            $table->enum('req_status', ['accepted', 'rejected', 'pending'])->default('pending');
            $table->string('category')->nullable();
            $table->enum('product_status', ['pending', 'processing', 'finished'])->default('pending');
            $table->foreignId('user_id')->nullable();
            $table->foreignId('price')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->enum('share_status', ['public', 'private'])->default('private');
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
