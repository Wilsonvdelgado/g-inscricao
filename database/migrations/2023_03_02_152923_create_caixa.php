<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCaixa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('caixa', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_movimento');
            $table->string('titulo');
            $table->string('descricao');
            $table->string('valor');
            $table->dateTime('data');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('inscritos_id')->constrained('inscritos');
            $table->timestamps();
        });
    }
    // $table->double('amount', 8, 2);

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('caixa');
    }
}
