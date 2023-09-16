<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChamadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chamados', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descricao');
            $table->unsignedBigInteger('cliente_id')->nullable();
            $table->string('cliente_nome')->nullable();
            $table->string('cliente_resposta')->nullable();
            $table->unsignedBigInteger('colaborador_id')->nullable()->nullable();
            $table->string('colaborador_nome')->nullable();
            $table->string('colaborador_resposta')->nullable();
            $table->string('status');
            $table->foreign('cliente_id')->references('id')->on('users');
            $table->foreign('colaborador_id')->references('id')->on('users');
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
        Schema::dropIfExists('chamados');
    }
}
