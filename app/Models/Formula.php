<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formula extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'descricao',
        'cliente_id',
        'observacoes',
    ];

    public function formulas()
    {
        return $this->belongsToMany(Formula::class, 'formula_ativos')
            ->withPivot('percentual')
            ->withTimestamps();
    }
}
