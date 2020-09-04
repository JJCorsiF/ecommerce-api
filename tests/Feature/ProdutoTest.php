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

    /**
     * @test
     *
     * @return void
     */
    public function umProdutoPodeSerCadastrado()
    {
        $novoProduto = [
            'produto' => [
                'codigo_produto' => 'Código do Produto',
                'nome' => 'Tecido',
                'cor' => 'vermelho',
                'tamanho' => 'médio',
                'valor' => 20.0,
            ],
        ];

        $response = $this->post('/produtos', $novoProduto);
        $response->assertStatus(201);

        $response->assertJsonStructure([
            'produto' => [
                'codigo_produto',
                'nome',
                'cor',
                'tamanho',
                'valor',
            ],
        ]);

        $produto = $novoProduto['produto'];

        $this->assertDatabaseHas('produtos', [
            'codigo_produto' => $produto['codigo_produto'],
            'nome' => $produto['nome'],
            'cor' => $produto['cor'],
            'tamanho' => $produto['tamanho'],
            'valor' => $produto['valor'],
        ]);
    }
}
