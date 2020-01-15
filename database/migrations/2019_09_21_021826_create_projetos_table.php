<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjetosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projetos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_categoria');
            $table->foreign('id_categoria')->references('id')->on('categorias');
            $table->string('nome');
            $table->string('descricao');
            $table->string('imagem_caminho');
            $table->string('vimeo');
            $table->string('vimeo_descricao');
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
        Schema::dropIfExists('projetos');
    }
}
