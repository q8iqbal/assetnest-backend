<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role_id')->unsigned();
            $table->integer('company_id')->unsigned();
            $table->string('name',255)->nullable(false);
            $table->string('email',255)->nullable(false);
            $table->string('password',255)->nullable(false);
            $table->string('photo',255)->nullable(true);
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
        Schema::dropIfExists('user', function(Blueprint $table){
            $table->dropSoftDeletes();
        });
    }
}
