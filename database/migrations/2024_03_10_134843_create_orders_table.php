<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->json('products');
            $table->unsignedInteger('count');
            $table->unsignedTinyInteger('status');
            $table->string('date')->nullable();
            $table->unsignedTinyInteger('payment_method')->nullable();
            $table->unsignedTinyInteger('delivery_method')->nullable();
            $table->string('region')->nullable();
            $table->string('city')->nullable();
            $table->string('delivery_address')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
