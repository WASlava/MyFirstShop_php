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
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->string('country', 100);
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->string('title', 100);
            $table->float('price');
            $table->longText('description');
            $table->boolean('is_favorite')->default(false);
            $table->foreignId('brand_id')->constrained('brands');
            $table->foreignId('category_id')->constrained('categories');


            $table->timestamps();
        });


        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->string('original_filename');
            $table->string('filename', 50)->unique();
            $table->string('disk', 50);
            $table->boolean('is_default')->default(false);
            $table->foreignId('product_id')->constrained('products');
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
        Schema::dropIfExists('brands');
        Schema::dropIfExists('product_images');

    }
};
