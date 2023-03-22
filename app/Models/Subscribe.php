<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subscribe extends Model
{
    protected $table = 'inscritos';
    // protected $pri

    protected $fillable = ["estado"];

    public function payments(): HasMany
    {
        return $this->hasMany(Caixa::class, "inscritos_id");
    }
}
