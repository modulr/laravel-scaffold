<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('order');
            $table->string('address');
            $table->integer('dealer_id')->unsigned()->nullable();
            $table->foreign('dealer_id')->references('id')->on('users');
            $table->integer('status_id')->unsigned()->nullable();
            $table->foreign('status_id')->references('id')->on('order_status');
            $table->integer('score_client')->nullable();
            $table->integer('score_dealer')->nullable();
            $table->float('order_cost')->nullable();
            $table->float('rate')->nullable();
            $table->integer('code_id')->unsigned()->nullable();
            $table->foreign('code_id')->references('id')->on('codes');
            $table->float('delivery_costs')->nullable();
            $table->float('total')->nullable();
            $table->unsignedInteger('created_by')->nullable()->default(null);
            $table->unsignedInteger('updated_by')->nullable()->default(null);
            $table->unsignedInteger('deleted_by')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();
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
