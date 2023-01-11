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
            $table->string('status')->default('tersedia');
            $table->string('brand');
            $table->string('assigned_location');
            $table->string('current_location');
            $table->unsignedBigInteger('division_id');
            $table->unsignedBigInteger('asset_category_id');
            $table->foreign('asset_category_id')->references('id')->on('asset_categories');
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
