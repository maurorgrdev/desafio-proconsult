<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArquivosChamadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arquivos_chamados', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('path');
            $table->string('filename');
            $table->unsignedBigInteger('chamado_id')->nullable();
            $table->unsignedBigInteger('usuario_id')->nullable();
            $table->foreign('chamado_id')->references('id')->on('chamados');
            $table->foreign('usuario_id')->references('id')->on('users');
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
        Schema::dropIfExists('arquivos_chamados');
    }
}
