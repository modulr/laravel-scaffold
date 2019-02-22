<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_company', function (Blueprint $table) {
          $table->integer('transaction_id')->unsigned();
          $table->foreign('transaction_id')->references('id')->on('transactions');
          $table->integer('company_id')->unsigned();
          $table->foreign('company_id')->references('id')->on('companies');
          $table->string('company_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_company');
    }
}
