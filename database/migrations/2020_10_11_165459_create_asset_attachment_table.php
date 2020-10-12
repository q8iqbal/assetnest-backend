<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetAttachmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_attachment', function (Blueprint $table) {
            $table->increments('id');
            $table->string('attachment',255)->nullable(false);
            $table->integer('asset_id')->unsigned();
            $table->foreign('asset_id')->references('id')->on('asset')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asset_attachment', function(Blueprint $table){
            $table->dropForeign('asset_attachment_asset_id_foreign');
            $table->dropIndex('asset_attachment_asset_id_foreign');
            $table->dropColumn('asset_id');
        });
    }
}
