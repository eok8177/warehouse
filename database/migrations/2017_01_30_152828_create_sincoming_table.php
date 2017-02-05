<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSincomingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_incoming', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('invoice_id');
            $table->foreign('invoice_id')->references('id')->on('s_invoices');

            $table->unsignedInteger('product_id');
            $table->foreign('product_id')->references('id')->on('s_products');

            $table->integer('count');
            $table->float('price')->nullable();
            $table->float('sum')->nullable();
            $table->date('date')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('s_incoming');
    }
}
