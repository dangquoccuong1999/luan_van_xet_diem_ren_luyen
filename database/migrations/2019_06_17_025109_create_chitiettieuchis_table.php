<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChitiettieuchisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chitiettieuchis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('name');
            $table->string('sodiem');
            $table->unsignedBigInteger('tieuchi_id');
            $table->foreign('tieuchi_id')
                ->references('id')->on('tieuchidanhgias')
                ->onDelete('cascade');

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
        Schema::dropIfExists('chitiettieuchis');
    }
}
