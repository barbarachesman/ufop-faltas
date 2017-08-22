<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTurmasTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'turmas';

    /**
     * Run the migrations.
     * @table turmas
     *
     * @return void
     */
     public function up()
    {
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('observacao')->nullable();
            $table->string('arquivo')->nullable();
            $table->boolean('status')->nullable();
            $table->unsignedInteger('faltas_aluno_id');
            $table->unsignedInteger('faltas_turma_id');
            $table->date('faltas_data');
            $table->date('faltas_data_final')->nullable();

            $table->index(["faltas_aluno_id", "faltas_turma_id", "faltas_data"], 'fk_justificativas_faltas1_idx');


            $table->foreign('faltas_aluno_id', 'fk_justificativas_faltas1_idx')
                ->references('aluno_id')->on('faltas')
                ->onDelete('no action')
                ->onUpdate('no action');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists($this->set_schema_table);
     }
}
