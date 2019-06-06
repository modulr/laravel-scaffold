<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAddColumnsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('cellphone');
            $table->text('address')->nullable()->after('phone');
            $table->string('facebook')->nullable()->after('phone');
            $table->string('instagram')->nullable()->after('facebook');
            $table->string('web')->nullable()->after('instagram');
            $table->string('link')->nullable()->after('web');
            $table->boolean('store')->default(false)->after('link');
            $table->integer('level')->default(0)->after('store');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
