<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('owner_id')->unsigned()->nullable(true);
            $table->string('logo',255)->nullable(true);
            $table->string('name',255)->nullable(false);
            $table->string('address',255)->nullable(false);
            $table->string('description',255)->nullable(true);
            $table->string('phone',255)->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company');
    }
}
