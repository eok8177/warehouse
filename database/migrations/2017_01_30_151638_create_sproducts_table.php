<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSproductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_products', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('bill_id')->nullable();
            $table->foreign('bill_id')->references('id')->on('s_bills');

            $table->string('title');
            $table->string('measure')->nullable();
            $table->decimal('quantity', 12, 2)->nullable();
            $table->decimal('sum', 20, 8)->nullable();
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
        Schema::dropIfExists('s_products');
    }
}
