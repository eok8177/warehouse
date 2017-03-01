<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSoutcomingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_outcoming', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('invoice_id')->nullable();
            $table->foreign('invoice_id')->references('id')->on('s_invoices');

            $table->unsignedInteger('product_id');
            $table->foreign('product_id')->references('id')->on('s_products');

            $table->unsignedInteger('client_id');
            $table->foreign('client_id')->references('id')->on('s_clients');

            $table->decimal('count', 12, 2);
            $table->decimal('sum', 20, 8)->nullable();
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
        Schema::dropIfExists('s_outcoming');
    }
}
