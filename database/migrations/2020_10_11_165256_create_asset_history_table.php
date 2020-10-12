<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_history', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('status_id')->unsigned()->index();
            $table->integer('company_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('user')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('status_id')->references('id')->on('asset_status')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('company_id')->references('id')->on('company')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamp('start_date',0);
            $table->timestamp('finish_date',0)->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asset_history', function(Blueprint $table){
            $table->dropForeign('asset_history_user_id_foreign');
            $table->dropIndex('asset_history_user_id_foreign');
            $table->dropColumn('user_id');
            
            $table->dropForeign('asset_history_status_id_foreign');
            $table->dropIndex('asset_history_status_id_foreign');
            $table->dropColumn('status_id');

            $table->dropForeign('asset_history_company_id_foreign');
            $table->dropIndex('asset_history_company_id_foreign');
            $table->dropColumn('company_id');
        });
    }
}
