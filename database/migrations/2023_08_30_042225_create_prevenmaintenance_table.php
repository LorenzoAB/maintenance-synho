<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrevenmaintenanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prevenmaintenance', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->text('parametro')->nullable();
            $table->text('factibilidad_revision')->nullable();
            $table->text('personal')->nullable();
            $table->text('pruebas')->nullable();
            $table->text('estado')->nullable();
            $table->text('solucion')->nullable();
            $table->text('observacion')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('prevenmaintenance');
    }
}
