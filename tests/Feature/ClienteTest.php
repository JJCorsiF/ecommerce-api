<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ClienteTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testTodosOsClientesSaoListados()
    {
        $response = $this->get('/clientes');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => [
                'codigo_cliente',
                'nome',
                'cpf',
                'sexo',
                'email',
            ]
        ]);
        $numeroDeClientesRetornados = count($response->decodeResponseJson());
        $this->assertDatabaseCount('clientes', $numeroDeClientesRetornados);
    }
}
