<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGiangviensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('giangviens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->date('ngaysinh');
            $table->tinyInteger('gioitinh');
            $table->string('hocvi');

            $table->unsignedBigInteger('khoa_id');
            $table->foreign('khoa_id')
                ->references('id')->on('khoas')
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
        Schema::dropIfExists('giangviens');
    }
}
