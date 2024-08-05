<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ativo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'descricao',
        'propriedades',
        'concentracao_maxima',
        'observacoes',
    ];

    public function ativos()
    {
        return $this->belongsToMany(Ativo::class, 'formula_ativos')
            ->withPivot('percentual')
            ->withTimestamps();
    }
}
