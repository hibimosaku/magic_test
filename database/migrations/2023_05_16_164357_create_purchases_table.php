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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('user_id')->constrained();
            $table->string('user_id');
            $table->string('name');
            $table->string('email');
            $table->enum('pay', ['cash', 'credit', 'bank']);
            $table->string('payId');
            $table->string('postal_code', 8);
            $table->string('prefecture');
            $table->string('city');
            $table->string('address1');
            $table->string('address2');
            // $table->string('tel');
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
        Schema::dropIfExists('purchases');
    }
};
