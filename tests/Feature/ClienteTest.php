<?php

namespace Tests\Feature;

use App\Cliente;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClienteTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     *
     * @return void
     */
    public function todosOsClientesSaoListados()
    {
        $response = $this->get('/clientes');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'clientes' => [
                '*' => [
                    'codigo_cliente',
                    'nome',
                    'cpf',
                    'sexo',
                    'email',
                ]
            ],
        ]);
        $numeroDeClientesRetornados = count($response->decodeResponseJson()['clientes']);
        $this->assertDatabaseCount('clientes', $numeroDeClientesRetornados);
    }

    /**
     * @test
     *
     * @return void
     */
    public function umClientePodeSerListado()
    {
        $cliente = Cliente::first();
        $response = $this->get('/clientes/' . $cliente->id_cliente);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'cliente' => [
                'codigo_cliente',
                'nome',
                'cpf',
                'sexo',
                'email',
            ],
        ]);

        $clienteRetornado = $response->decodeResponseJson()['cliente'];

        $this->assertDatabaseHas('clientes', [
            'codigo_cliente' => $clienteRetornado['codigo_cliente'],
            'nome' => $clienteRetornado['nome'],
            'cpf' => $clienteRetornado['cpf'],
            'sexo' => $clienteRetornado['sexo'],
            'email' => $clienteRetornado['email'],
        ]);
    }

    /**
     * @test
     *
     * @return void
     */
    public function umClientePodeSerCadastrado()
    {
        $novoCliente = [
            'cliente' => [
                'codigo_cliente' => 'Código do Cliente',
                'nome' => 'John Doe',
                'cpf' => '98765432100',
                'sexo' => 'masculino',
                'email' => 'a@b.c',
            ],
        ];

        $response = $this->post('/clientes', $novoCliente);
        $response->assertStatus(201);

        $response->assertJsonStructure([
            'cliente' => [
                'codigo_cliente',
                'nome',
                'cpf',
                'sexo',
                'email',
            ],
        ]);

        $clienteRetornado = $novoCliente['cliente'];

        $this->assertDatabaseHas('clientes', [
            'codigo_cliente' => $clienteRetornado['codigo_cliente'],
            'nome' => $clienteRetornado['nome'],
            'cpf' => $clienteRetornado['cpf'],
            'sexo' => $clienteRetornado['sexo'],
            'email' => $clienteRetornado['email'],
        ]);
    }
}
