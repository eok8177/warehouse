<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('works', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('lpz_id');
            $table->foreign('lpz_id')->references('id')->on('lpz');

            $table->unsignedInteger('cat_id');
            $table->foreign('cat_id')->references('id')->on('work_categories');
            $table->string('invoice')->nullable();
            $table->float('summ')->nullable();
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
        Schema::dropIfExists('works');
    }
}
