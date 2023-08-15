<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('request_id');
            $table->unsignedBigInteger('asset_id');
            $table->unsignedBigInteger('asset_jenis_id');
            $table->string('status')->nullable();
            $table->foreign('request_id')->references('id')->on('requests');
            $table->foreign('asset_id')->references('id')->on('assets');
            $table->foreign('asset_jenis_id')->references('id')->on('asset_jenis');
            $table->dateTime('taken_date')->nullable();
            $table->dateTime('realize_return_date')->nullable();
            $table->string('return_conditions')->nullable();
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
        Schema::dropIfExists('bookings');
    }
}
