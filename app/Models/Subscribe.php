<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Subscribe extends Model
{
    protected $table = 'inscritos';
    use HasFactory;
    // protected $pri

    protected $fillable = ["estado", "pagamento_completo", "observacao"];

    public function payments(): HasMany
    {
        return $this->hasMany(Caixa::class, "inscritos_id");
    }

    
    public function pacote(): HasOne
    {
        return $this->hasOne(Pacote::class,'id', 'pacotes_id');
    }
}
