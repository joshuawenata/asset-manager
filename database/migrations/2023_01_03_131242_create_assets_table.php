<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('serial_number')->unique();
            $table->string('status')->default('tidak tersedia');
            $table->string('kategori_barang');
            $table->string('spesifikasi_barang');
            $table->string('brand');
            $table->string('current_location');
            $table->string('pemilik_barang');
            $table->unsignedBigInteger('division_id');
            $table->unsignedBigInteger('asset_jenis_id');
            $table->foreign('asset_jenis_id')->references('id')->on('asset_jenis');
            $table->foreign('division_id')->references('id')->on('divisions');
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
        Schema::dropIfExists('assets');
    }
}
