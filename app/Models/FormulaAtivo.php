<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class FormulaAtivo extends Pivot
{
    use HasFactory;

    protected $table = 'formula_ativos';

    protected $fillable = [
        'formula_id',
        'ativo_id',
        'percentual',
        'observacoes',
    ];
}
