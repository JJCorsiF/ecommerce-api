<?php

namespace Tests\Feature;

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
}
