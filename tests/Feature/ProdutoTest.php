<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProdutoTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     *
     * @return void
     */
    public function todosOsProdutosSaoListados()
    {
        $response = $this->get('/produtos');
        $response->assertStatus(200);

        $response->assertJsonStructure([
            'produtos' => [
                '*' => [
                    'codigo_produto',
                    'nome',
                    'cor',
                    'tamanho',
                    'valor',
                ]
            ],
        ]);
        $numeroDeProdutosRetornados = count($response->decodeResponseJson()['produtos']);
        $this->assertDatabaseCount('produtos', $numeroDeProdutosRetornados);
    }
}
