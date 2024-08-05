<?php

use App\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientTest extends TestCase
{
    use RefreshDatabase;

    public function testGetAllClients()
    {
        // Cria alguns clientes no banco de dados
        Client::factory()->count(3)->create();

        // Obtém todos os clientes
        $clients = Client::all();

        // Verifica se a coleção não está vazia e contém instâncias da classe Client
        $this->assertNotEmpty($clients);
        foreach ($clients as $client) {
            $this->assertInstanceOf(Client::class, $client);
        }
    }

    public function testGetClientById()
    {
        // Cria um cliente no banco de dados
        $client = Client::factory()->create();

        // Obtém o cliente pelo ID
        $foundClient = Client::find($client->id);

        // Verifica se o cliente foi encontrado e se é uma instância da classe Client
        $this->assertNotNull($foundClient);
        $this->assertInstanceOf(Client::class, $foundClient);
    }

    public function testCreateClient()
    {
        // Cria um novo cliente
        $client = Client::factory()->make();

        // Salva o cliente no banco de dados
        $client->save();

        // Obtém o cliente pelo ID
        $foundClient = Client::find($client->id);

        // Verifica se o cliente foi encontrado e se é uma instância da classe Client
        $this->assertNotNull($foundClient);
        $this->assertInstanceOf(Client::class, $foundClient);
    }

    public function testUpdateClient()
    {
        // Cria um cliente no banco de dados
        $client = Client::factory()->create();

        // Atualiza o nome do cliente
        $client->nome = 'New Name';
        $client->save();

        // Obtém o cliente pelo ID
        $foundClient = Client::find($client->id);

        // Verifica se o nome do cliente foi atualizado
        $this->assertEquals('New Name', $foundClient->nome);
    }

    public function testDeleteClient()
    {
        // Cria um cliente no banco de dados
        $client = Client::factory()->create();

        // Deleta o cliente
        $client->delete();

        // Obtém o cliente pelo ID
        $foundClient = Client::find($client->id);

        // Verifica se o cliente não foi encontrado
        $this->assertNull($foundClient);
    }
}

