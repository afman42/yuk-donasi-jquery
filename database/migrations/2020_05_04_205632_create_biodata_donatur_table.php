<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBiodataDonaturTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('biodata_donatur', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('jenis_kelamin');
            $table->string('no_hp',15);
            $table->text('alamat');
            $table->string('gambar');
            $table->integer('user_id');
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
        Schema::dropIfExists('biodata_donatur');
    }
}
