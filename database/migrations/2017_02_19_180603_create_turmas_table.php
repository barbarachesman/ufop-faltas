<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTurmasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('turmas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('disciplina_id')->unsigned();
            $table->integer('periodo_id')->unsigned();
            $table->string('codigo');
            $table->boolean('finalizada');

            $table->foreign('disciplina_id')
                ->references('id')->on('disciplinas')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('periodo_id')
                ->references('id')->on('periodos')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('turmas');
    }
}
