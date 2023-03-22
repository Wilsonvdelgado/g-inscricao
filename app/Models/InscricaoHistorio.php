<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InscricaoHistorio extends Model
{
    protected $table = 'inscricao_historico';
    public $timestamps = false;

    protected $fillable = ['inscritos_id', 'tipo', 'data', 'titulo', 'descricao'];

    // protected $pri

    // public function payments(): HasMany
    // {
    //     return $this->hasMany(Caixa::class, "inscritos_id");
    // }
}
