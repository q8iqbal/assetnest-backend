<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable(true);
            $table->integer('type_id')->unsigned();
            $table->integer('status_id')->unsigned();
            $table->integer('company_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('user')->onDelete('SET NULL')->onUpdate('cascade');
            $table->foreign('type_id')->references('id')->on('asset_type')->onDelete('no action')->onUpdate('cascade');
            $table->foreign('status_id')->references('id')->on('asset_status')->onDelete('no action')->onUpdate('cascade');
            $table->foreign('company_id')->references('id')->on('company')->onDelete('cascade')->onUpdate('cascade');
            $table->string('photo',255);
            $table->string('product_code',255)->nullable(false);
            $table->string('name',255)->nullable(false);
            $table->timestamp('purchase_date',0);
            $table->timestamp('start_date', 0)->useCurrent();
            $table->string('location',255);
            $table->string('price',255);
            $table->string('note', 255);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asset', function(Blueprint $table){
            $table->dropForeign('asset_user_id_foreign');
            $table->dropIndex('asset_user_id_foreign');
            $table->dropColumn('user_id');

            $table->dropForeign('asset_type_id_foreign');
            $table->dropIndex('asset_type_id_foreign');
            $table->dropColumn('type_id');

            $table->dropForeign('asset_status_id_foreign');
            $table->dropIndex('asset_status_id_foreign');
            $table->dropColumn('status_id');

            $table->dropForeign('asset_company_id_foreign');
            $table->dropIndex('asset_company_id_foreign');
            $table->dropColumn('company_id');
        });
    }
}
