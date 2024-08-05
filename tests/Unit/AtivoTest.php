<?php

use App\Models\Ativo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AtivoTest extends TestCase
{
    use RefreshDatabase;

    public function testGetAllAtivos()
    {
        // Cria alguns ativos no banco de dados
        Ativo::factory()->count(3)->create();

        // Obtém todos os ativos
        $ativos = Ativo::all();

        // Verifica se a coleção não está vazia e contém instâncias da classe Ativo
        $this->assertNotEmpty($ativos);
        foreach ($ativos as $ativo) {
            $this->assertInstanceOf(Ativo::class, $ativo);
        }
    }

    public function testGetAtivoById()
    {
        // Cria um ativo no banco de dados
        $ativo = Ativo::factory()->create();

        // Obtém o ativo pelo ID
        $foundAtivo = Ativo::find($ativo->id);

        // Verifica se o ativo foi encontrado e se é uma instância da classe Ativo
        $this->assertNotNull($foundAtivo);
        $this->assertInstanceOf(Ativo::class, $foundAtivo);
    }

    public function testCreateAtivo()
    {
        // Cria um novo ativo
        $ativo = Ativo::factory()->make();

        // Salva o ativo no banco de dados
        $ativo->save();

        // Obtém o ativo pelo ID
        $foundAtivo = Ativo::find($ativo->id);

        // Verifica se o ativo foi encontrado e se é uma instância da classe Ativo
        $this->assertNotNull($foundAtivo);
        $this->assertInstanceOf(Ativo::class, $foundAtivo);
    }

    public function testUpdateAtivo()
    {
        // Cria um ativo no banco de dados
        $ativo = Ativo::factory()->create();

        // Atualiza o nome do ativo
        $ativo->nome = 'Novo nome';
        $ativo->save();

        // Obtém o ativo pelo ID
        $foundAtivo = Ativo::find($ativo->id);

        // Verifica se o nome do ativo foi atualizado
        $this->assertEquals('Novo nome', $foundAtivo->nome);
    }

    public function testDeleteAtivo()
    {
        // Cria um ativo no banco de dados
        $ativo = Ativo::factory()->create();

        // Deleta o ativo
        $ativo->delete();

        // Verifica se o ativo foi removido do banco de dados
        $this->assertNull(Ativo::find($ativo->id));
    }

}
