<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInscritos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inscritos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->dateTime('data_inscricao');
            $table->string('email');
            $table->string('sexo');
            $table->date('data_nascimento');
            $table->string('pais_residencia');
            $table->string('diocese');
            $table->string('paroquia');
            $table->string('ilha');
            $table->string('responsabilidade_pastoral');
            $table->string('escolaridade');
            $table->string('profissao');
            $table->string('telemovel');
            $table->string('pertence_a_grupo_religioso');
            $table->string('ja_participou_na_jornada');
            $table->string('tem_necessidade_especial');
            $table->string('precisa_visto_portugal');
            $table->string('anexo');
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
        Schema::dropIfExists('inscritos');
    }
}
