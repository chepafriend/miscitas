<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitaCanceladasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cita_canceladas', function (Blueprint $table) {
          
            $table->increments('id');
            
            $table->unsignedInteger('cita_id');
            $table->foreign('cita_id')->references('id')->on('citas');

            $table->String('justificacion')->nullable();

            $table->unsignedInteger('cancelado_por_id');
            $table->foreign('cancelado_por_id')->references('id')->on('users');

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
        Schema::dropIfExists('cita_canceladas');
    }
}
