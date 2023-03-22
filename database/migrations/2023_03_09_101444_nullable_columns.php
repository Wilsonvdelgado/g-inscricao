<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NullableColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inscritos', function (Blueprint $table) {
            $table->string('grupo')->nullable();
            $table->string('pais_ano_participacao_jmj')->nullable();
            $table->string('necessidade_especial')->nullable();
            $table->string('nome_rede_social')->nullable();
            $table->string('escolaridade')->nullable()->change();
            $table->string('profissao')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
