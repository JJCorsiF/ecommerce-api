<?php

namespace Tests\Feature;

use App\Pedido;
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
}
