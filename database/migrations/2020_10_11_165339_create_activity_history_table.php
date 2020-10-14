<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_history', function (Blueprint $table) {
            $table->increments('id');
            // $table->string('user_email',255)->nullable(false);
            // $table->string('user_name',255)->nullable(false);
            $table->integer('user_id')->unsigned();
            $table->integer('admin_id')->unsigned();
            $table->integer('company_id')->unsigned();
            $table->integer('activity_id')->unsigned();
            $table->foreign('admin_id')->references('id')->on('user')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('company_id')->references('id')->on('company')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('activity_id')->references('id')->on('activity')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('user')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamp('activity_date',0)->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activity_history', function(Blueprint $table){
            $table->dropForeign('activity_history_user_id_foreign');
            $table->dropIndex('activity_history_user_id_foreign');
            $table->dropColumn('user_id');

            $table->dropForeign('activity_history_admin_id_foreign');
            $table->dropIndex('activity_history_admin_id_foreign');
            $table->dropColumn('admin_id');
            
            $table->dropForeign('activity_history_status_id_foreign');
            $table->dropIndex('activity_history_status_id_foreign');
            $table->dropColumn('status_id');

            $table->dropForeign('activity_history_company_id_foreign');
            $table->dropIndex('activity_history_company_id_foreign');
            $table->dropColumn('company_id');
        });
    }
}
