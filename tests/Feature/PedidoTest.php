<?php

namespace Tests\Feature;

use App\Cliente;
use App\Mail\PedidoRealizado;
use App\Pedido;
use App\Produto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
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

    /**
     * @test
     *
     * @return void
     */
    public function umPedidoPodeSerAtualizado()
    {
        $produtos = Produto::inRandomOrder()->limit(rand(1, 3))->get();
        $produtosSelecionados = [];

        foreach ($produtos as $produto) {
            $produtosSelecionados[] = [
                'id_produto' => $produto->id_produto,
                'quantidade' => rand(1, 9),
            ];
        }

        $pedido = Pedido::inRandomOrder()->first();
        $payload = [
            'id_cliente' => Cliente::inRandomOrder()->first()->id_cliente,
            'codigo_pedido' => 'Código do Pedido',
            'data_pedido' => (new \DateTime())->format('Y-m-d H:i:s'),
            'observacao' => 'pedido novo',
            'forma_pagamento' => 'dinheiro',
            'produtos' => $produtosSelecionados,
        ];
        $response = $this->put('/pedidos/' . $pedido->id_pedido, $payload);

        $response->assertStatus(200);

        $this->assertDatabaseHas('pedidos', [
            'id_pedido' => $pedido->id_pedido,
            'id_cliente' => $payload['id_cliente'],
            'codigo_pedido' => $payload['codigo_pedido'],
            'data_pedido' => $payload['data_pedido'],
            'observacao' => $payload['observacao'],
            'forma_pagamento' => $payload['forma_pagamento'],
        ]);

        foreach ($produtosSelecionados as $produto) {
            $this->assertDatabaseHas('produtos_pedido', [
                'id_pedido' => $pedido->id_pedido,
                'id_produto' => $produto['id_produto'],
                'quantidade' => $produto['quantidade'],
            ]);
        }

        $response->assertJson([
            'pedido' => [
                'id_pedido' => $pedido->id_pedido,
                'id_cliente' => $payload['id_cliente'],
                'codigo_pedido' => $payload['codigo_pedido'],
                'data_pedido' => $payload['data_pedido'],
                'observacao' => $payload['observacao'],
                'forma_pagamento' => $payload['forma_pagamento'],
            ],
        ]);
    }

    /**
     * @test
     *
     * @return void
     */
    public function umPedidoPodeSerDeletado()
    {
        $pedido = Pedido::inRandomOrder()->first();

        $response = $this->delete('/pedidos/' . $pedido->id_pedido);

        $response->assertStatus(204);

        $this->assertDatabaseMissing('pedidos', [
            'id_pedido' => $pedido->id_pedido,
            'codigo_pedido' => $pedido->codigo_pedido,
            'data_pedido' => $pedido->data_pedido,
            'observacao' => $pedido->observacao,
            'forma_pagamento' => $pedido->forma_pagamento,
        ]);
        $this->assertDeleted('pedidos', [
            'id_pedido' => $pedido->id_pedido,
            'codigo_pedido' => $pedido->codigo_pedido,
            'data_pedido' => $pedido->data_pedido,
            'observacao' => $pedido->observacao,
            'forma_pagamento' => $pedido->forma_pagamento,
        ]);
    }

    /**
     * @test
     *
     * @return void
     */
    public function umPedidoPodeSerEnviadoPorEmail()
    {
        Mail::fake();

        $pedido = Pedido::inRandomOrder()->first();

        $cliente = Cliente::where('id_cliente', $pedido->id_cliente)->first();

        $response = $this->post('/pedidos/' . $pedido->id_pedido . '/sendmail');
        $response->assertStatus(200);

        Mail::assertSent(PedidoRealizado::class, function ($mail) use ($cliente) {
            return $mail->hasTo($cliente->email);
        });
    }

    /**
     * @test
     *
     * @return void
     */
    public function umPedidoPodeSerGeradoEmPdf()
    {
        $pedido = Pedido::inRandomOrder()->first();

        $response = $this->post('/pedidos/' . $pedido->id_pedido . '/report');
        $response->assertStatus(200);

        $response->assertHeader('Content-Type', 'application/pdf');
    }
}
