<?php

namespace Tests\Feature;

use App\Cliente;
use App\Pedido;
use App\Produto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PedidoTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     *
     * @return void
     */
    public function todosOsPedidosSaoListados()
    {
        $response = $this->get('/pedidos');
        $response->assertStatus(200);

        $response->assertJsonStructure([
            'pedidos' => [
                '*' => [
                    'codigo_pedido',
                    'data_pedido',
                    'observacao',
                    'forma_pagamento',
                ]
            ],
        ]);
        $numeroDePedidosRetornados = count($response->decodeResponseJson()['pedidos']);
        $this->assertDatabaseCount('pedidos', $numeroDePedidosRetornados);
    }

    /**
     * @test
     *
     * @return void
     */
    public function umPedidoPodeSerListado()
    {
        $pedido = Pedido::inRandomOrder()->first();
        $response = $this->get('/pedidos/' . $pedido->id_pedido);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'pedido' => [
                'codigo_pedido',
                'data_pedido',
                'observacao',
                'forma_pagamento',
            ],
        ]);

        $pedidoRetornado = $response->decodeResponseJson()['pedido'];

        $this->assertDatabaseHas('pedidos', [
            'codigo_pedido' => $pedidoRetornado['codigo_pedido'],
            'data_pedido' => $pedidoRetornado['data_pedido'],
            'observacao' => $pedidoRetornado['observacao'],
            'forma_pagamento' => $pedidoRetornado['forma_pagamento'],
        ]);
    }

    /**
     * @test
     *
     * @return void
     */
    public function umPedidoPodeSerCadastrado()
    {
        $produtos = Produto::inRandomOrder()->limit(rand(1, 3))->get();
        $produtosSelecionados = [];

        foreach ($produtos as $produto) {
            $produtosSelecionados[] = [
                'id_produto' => $produto->id_produto,
                'quantidade' => rand(1, 9),
            ];
        }

        $novoPedido = [
            'pedido' => [
                'id_cliente' => Cliente::inRandomOrder()->first()->id_cliente,
                'codigo_pedido' => 'Código do Pedido',
                'data_pedido' => (new \DateTime())->format('Y-m-d H:i:s'),
                'observacao' => 'pedido novo',
                'forma_pagamento' => 'dinheiro',
                'produtos' => $produtosSelecionados,
            ],
        ];

        $response = $this->post('/pedidos', $novoPedido);
        $response->assertStatus(201);

        $response->assertJsonStructure([
            'pedido' => [
                'codigo_pedido',
                'data_pedido',
                'observacao',
                'forma_pagamento',
            ],
        ]);

        $pedido = $novoPedido['pedido'];

        $this->assertDatabaseHas('pedidos', [
            'codigo_pedido' => $pedido['codigo_pedido'],
            'data_pedido' => $pedido['data_pedido'],
            'observacao' => $pedido['observacao'],
            'forma_pagamento' => $pedido['forma_pagamento'],
        ]);
    }
}
