<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTabelaHistorio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inscricao_historico', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inscritos_id')->constrained('inscritos')->nullable();
            $table->string('tipo');
            $table->dateTime('data');
            $table->string('titulo');
            $table->string('descricao')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tabela_historio');
    }
}
