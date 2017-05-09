<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAoutcomingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('a_outcoming', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('invoice_id')->nullable();
            $table->foreign('invoice_id')->references('id')->on('a_invoices');

            $table->unsignedInteger('product_id');
            $table->foreign('product_id')->references('id')->on('a_products');

            $table->unsignedInteger('client_id');
            $table->foreign('client_id')->references('id')->on('a_clients');

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
        Schema::dropIfExists('a_outcoming');
    }
}
