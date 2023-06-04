<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('information');
            $table->unsignedInteger('price');
            $table->foreignId('size_id')->constrained();
            $table->boolean('is_selling');
            $table->integer('sort_order');
            $table->foreignId('secondary_category_id')->constrained();
            $table->foreignId('image1')->constrained('images');
            $table->foreignId('image2')->nullable()->constrained('images');
            $table->foreignId('image3')->nullable()->constrained('images');
            $table->foreignId('image4')->nullable()->constrained('images');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
};
