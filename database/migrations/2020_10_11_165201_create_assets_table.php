<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('code',255);
            $table->string('name',255);
            $table->enum('status', ['available' , 'dipinjam' , 'diservis' , 'hilang' , 'rusak']);
            $table->string('price',255);
            $table->string('image',255)->nullable();
            $table->string('location',255)->nullable();
            $table->string('note', 255)->nullable();
            $table->enum('type', ['Desktop', 'Vehicle', 'Machine', 'Accessories', 'Document', 'etc']);
            $table->timestamp('purchase_date',0)->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assets', function(Blueprint $table){
            $table->dropForeign(['company_id']);
        });
    }
}
