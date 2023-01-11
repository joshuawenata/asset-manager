<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * Status Request value:
     *  waiting approval

    canceled
    rejected
    approved

    on use
    done
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->dateTime('book_date');
            $table->dateTime('return_date');
            $table->text('purpose');
            $table->string('status')->default('waiting approval');
            $table->text('return_notes')->nullable();
            $table->integer('track_approver')->default('0');
            $table->string('lokasi', 1000);
            $table->boolean('flag_return')->nullable();
            $table->dateTime('realize_return_date')->nullable();
            $table->string('return_status')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('requests');
    }
}
