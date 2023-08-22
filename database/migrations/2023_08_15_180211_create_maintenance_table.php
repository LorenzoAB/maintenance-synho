<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->dateTime('fecha_inicio')->nullable();
            $table->dateTime('fecha_final')->nullable();
            $table->text('maquina')->nullable();
            $table->text('proceso')->nullable();
            $table->text('descripcion')->nullable();
            $table->string('estado')->default('Activo');
            $table->text('ejecutor')->nullable();
            $table->text('nivel_criticidad')->nullable();
            $table->text('estado_previo')->nullable();
            $table->text('solucion_efectuada')->nullable();
            $table->text('estado_actual')->nullable();
            $table->text('observacion')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('maintenance');
    }
}
