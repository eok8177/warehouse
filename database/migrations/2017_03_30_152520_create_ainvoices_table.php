<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAinvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('a_invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');

            $table->unsignedInteger('supplier_id');
            $table->foreign('supplier_id')->references('id')->on('a_suppliers');

            $table->decimal('price', 20, 8)->nullable();
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
        Schema::dropIfExists('a_invoices');
    }
}
