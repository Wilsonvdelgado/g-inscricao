<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Caixa extends Model
{
    protected $table = 'caixa';


    // public function subscribe(): HasOne
    // {
    //     return $this->hasOne(Subscribe::class, "inscritos_id");
    // }

    protected $fillable = ["tipo_movimento", "titulo", "descricao", "valor", "data", "numero_pagamento", "user_id", "inscritos_id"];
}
