<?php

namespace Tests\Feature;

use App\Produto;
use Illuminate\Foundation\Testing\RefreshDatabase;
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

    /**
     * @test
     *
     * @return void
     */
    public function umProdutoPodeSerListado()
    {
        $produto = Produto::first();
        $response = $this->get('/produtos/' . $produto->id_produto);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'produto' => [
                'codigo_produto',
                'nome',
                'cor',
                'tamanho',
                'valor',
            ],
        ]);

        $produtoRetornado = $response->decodeResponseJson()['produto'];

        $this->assertDatabaseHas('produtos', [
            'codigo_produto' => $produtoRetornado['codigo_produto'],
            'nome' => $produtoRetornado['nome'],
            'cor' => $produtoRetornado['cor'],
            'tamanho' => $produtoRetornado['tamanho'],
            'valor' => $produtoRetornado['valor'],
        ]);
    }
}
