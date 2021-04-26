<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSinhviensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sinhviens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('masv');
            $table->date('ngaysinh');
            $table->tinyInteger('gioitinh');
            $table->unsignedBigInteger('lop_id');
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
        Schema::dropIfExists('sinhviens');
    }
}
