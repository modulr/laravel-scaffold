<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->text('name');
            $table->integer('company_import_id')->unsigned()->nullable();
            $table->foreign('company_import_id')->references('id')->on('companies');
            $table->integer('company_export_id')->unsigned()->nullable();
            $table->foreign('company_export_id')->references('id')->on('companies');
            $table->integer('customs_import_id')->unsigned()->nullable();
            $table->foreign('customs_import_id')->references('id')->on('companies');
            $table->integer('customs_export_id')->unsigned()->nullable();
            $table->foreign('customs_export_id')->references('id')->on('companies');
            $table->integer('finished')->boolean()->default(false);
            $table->integer('finished_by')->unsigned()->nullable();
            $table->foreign('finished_by')->references('id')->on('users');
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
        Schema::dropIfExists('transactions');
    }
}
