<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailprevenmaintenanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detailprevenmaintenance', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('prevenmaintenance_id')->index();
            $table->text('maquina')->nullable();
            $table->text('elementos')->nullable();
            $table->text('revision')->nullable();
            $table->text('fechaprogramada')->nullable();
            $table->timestamps();
            $table->foreign('prevenmaintenance_id')->references('id')->on('prevenmaintenance')->onDelete('cascade');
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detailprevenmaintenance');
    }
}
