<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Pacote extends Model
{
    protected $table = 'pacotes';


    // public function subscribe(): HasOne
    // {
    //     return $this->hasOne(Subscribe::class, "inscritos_id");
    // }

    // protected $fillable = ["tipo_movimento", "titulo", "descricao", "valor", "data", "numero_pagamento", "user_id", "inscritos_id"];
}