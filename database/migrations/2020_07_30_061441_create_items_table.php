<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->Increments('id');
            $table->integer('licensor_id')->unsigned();
            $table->string('item_name',255);
            $table->integer('total_item');
            $table->integer('stock_item');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('licensor_id')->references('id')->on('licensors')->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
     Schema::dropIfExists('goods');
    }
}
