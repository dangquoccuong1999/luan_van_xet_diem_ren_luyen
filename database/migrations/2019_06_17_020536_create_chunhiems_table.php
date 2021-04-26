<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChunhiemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chunhiems', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('giangvien_id');
            $table->unsignedBigInteger('lop_id');
            $table->foreign('giangvien_id')
                ->references('id')->on('giangviens')
                ->onDelete('cascade');

            $table->foreign('lop_id')
                ->references('id')->on('lops')
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
        Schema::dropIfExists('chunhiems');
    }
}
