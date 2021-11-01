<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendingOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pending_orders', function (Blueprint $table) {
            $table->id();
            $table->integer('order_number');
            $table->bigInteger('user_id');
            $table->bigInteger('customer_id')->nullable();
            $table->bigInteger('product_id');
            $table->double('quantity');
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
        Schema::dropIfExists('pending_orders');
    }
}
