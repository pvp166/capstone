<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_id')->references('id')->on('orders');
            $table->unsignedBigInteger('item_price_id')->references('id')->on('item_prices');
            $table->unsignedBigInteger('quantity')->default('1');
            $table->integer('rating')->nullable();
            $table->string('special_instructions')->nullable();
            $table->string('comments')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_items');
    }
}
