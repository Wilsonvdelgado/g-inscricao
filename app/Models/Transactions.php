<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    protected $table = 'caixa';

    // public function payments(): HasMany
    // {
    //     return $this->hasMany(Comment::class);
    // }
}
