<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiemDanhGiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diem_danh_gias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('diem');
            $table->unsignedBigInteger('chitiettieuchi_id');
            $table->foreign('chitiettieuchi_id')
                ->references('id')->on('chitiettieuchis')
                ->onDelete('cascade');

            $table->unsignedBigInteger('sinhvien_id');
            $table->foreign('sinhvien_id')
                ->references('id')->on('sinhviens')
                ->onDelete('cascade');


            $table->unsignedBigInteger('giangvien_id');
            $table->foreign('giangvien_id')
                ->references('id')->on('giangviens')
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
        Schema::dropIfExists('diem_danh_gias');
    }
}
