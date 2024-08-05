<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Formula;
use App\Models\Ativo;

class FormulaAtivoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Cria algumas Fórmulas e Ativos
        $formulas = Formula::factory()->count(5)->create();
        $ativos = Ativo::factory()->count(10)->create();

        // Associa cada Fórmula com alguns Ativos
        foreach ($formulas as $formula) {
            foreach ($ativos->random(rand(1, 3)) as $ativo) {
                $formula->ativos()->attach($ativo->id, [
                    'percentual' => rand(1, 100),
                    'observacoes' => 'Observação para o ativo ' . $ativo->id
                ]);
            }
        }
    }
}
