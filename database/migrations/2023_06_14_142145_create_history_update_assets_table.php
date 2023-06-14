<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_update_assets', function (Blueprint $table) {
            $table->id();
            $table->string("id_pengubah");
            $table->string("nama_pengubah");
            $table->string("kode_barang");
            $table->string("kategori_barang");
            $table->string("status_barang");
            $table->string("spesifikasi_barang");
            $table->string("pemilik_barang");
            $table->string("new_kode_barang");
            $table->string("new_kategori_barang");
            $table->string("new_status_barang");
            $table->string("new_spesifikasi_barang");
            $table->string("new_pemilik_barang");
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
        Schema::dropIfExists('history_update_assets');
    }
};
