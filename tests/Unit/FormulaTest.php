<?php

use App\Models\Formula;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FormulaTest extends TestCase
{
    use RefreshDatabase;

    public function testGetAllFormulas()
    {
        // Cria algumas fórmulas no banco de dados
        Formula::factory()->count(3)->create();

        // Obtém todas as fórmulas
        $formulas = Formula::all();

        // Verifica se a coleção não está vazia e contém instâncias da classe Formula
        $this->assertNotEmpty($formulas);
        foreach ($formulas as $formula) {
            $this->assertInstanceOf(Formula::class, $formula);
        }
    }

    public function testGetFormulaById()
    {
        // Cria uma fórmula no banco de dados
        $formula = Formula::factory()->create();

        // Obtém a fórmula pelo ID
        $foundFormula = Formula::find($formula->id);

        // Verifica se a fórmula foi encontrada e se é uma instância da classe Formula
        $this->assertNotNull($foundFormula);
        $this->assertInstanceOf(Formula::class, $foundFormula);
    }

    public function testCreateFormula()
    {
        // Cria uma nova fórmula
        $formula = Formula::factory()->make();

        // Salva a fórmula no banco de dados
        $formula->save();

        // Obtém a fórmula pelo ID
        $foundFormula = Formula::find($formula->id);

        // Verifica se a fórmula foi encontrada e se é uma instância da classe Formula
        $this->assertNotNull($foundFormula);
        $this->assertInstanceOf(Formula::class, $foundFormula);
    }

    public function testUpdateFormula()
    {
        // Cria uma fórmula no banco de dados
        $formula = Formula::factory()->create();

        // Atualiza o nome da fórmula
        $formula->nome = 'Nova Fórmula';
        $formula->save();

        // Obtém a fórmula atualizada pelo ID
        $updatedFormula = Formula::find($formula->id);

        // Verifica se o nome da fórmula foi atualizado corretamente
        $this->assertEquals('Nova Fórmula', $updatedFormula->nome);
    }

    public function testDeleteFormula()
    {
        // Cria uma fórmula no banco de dados
        $formula = Formula::factory()->create();

        // Deleta a fórmula
        $formula->delete();

        // Verifica se a fórmula não existe mais no banco de dados
        $this->assertNull(Formula::find($formula->id));
    }
}
