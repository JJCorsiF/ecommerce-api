<?php

namespace App\Http\Controllers;

use App\Pedido;
use App\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PedidoController extends Controller
{
    public function listarPedidos()
    {
        $pedidos = Pedido::all();

        return response()->json([
            'pedidos' => $pedidos,
        ], 200);
    }

    public function buscarPedido($id)
    {
        $pedido = Pedido::where('id_pedido', $id)->orWhere('uuid_pedido', $id)->first();

        return response()->json([
            'pedido' => $pedido,
        ], 200);
    }

    public function adicionarPedido(Request $request)
    {
        try {
            $pedidoAAdicionar = $request->pedido;

            $pedido = Pedido::create([
                'id_cliente' => $pedidoAAdicionar['id_cliente'],
                'uuid_pedido' => Str::uuid(),
                'codigo_pedido' => $pedidoAAdicionar['codigo_pedido'],
                'data_pedido' => $pedidoAAdicionar['data_pedido'],
                'observacao' => $pedidoAAdicionar['observacao'],
                'forma_pagamento' => $pedidoAAdicionar['forma_pagamento'],
            ]);

            $produtos = $pedidoAAdicionar['produtos'];

            foreach ($produtos as $produtoDoPedido) {
                $idDoProduto = $produtoDoPedido['id_produto'];
                $produto = Produto::where('id_produto', $idDoProduto)->orWhere('uuid_produto', $idDoProduto)->first();

                $pedido->produtos()->save($produto, ['quantidade' => $produtoDoPedido['quantidade'],]);
            }

            return response()->json([
                'pedido' => $pedido,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function atualizarPedido(Request $request, $id)
    {
        try {
            $pedido = Pedido::where('id_pedido', $id)->orWhere('uuid_pedido', $id)->firstOrFail();

            $pedido->update($request->all());

            $produtos = $request->produtos;

            foreach ($produtos as $produto) {
                $pedido->produtos()->updateExistingPivot($produto['id_produto'], ['quantidade' => $produto['quantidade'],]);
            }

            return response()->json([
                'pedido' => $pedido,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function deletarPedido($id)
    {
        $pedido = Pedido::where('id_pedido', $id)->orWhere('uuid_pedido', $id)->firstOrFail();
        $pedido->delete();

        return response()->json([
            'pedido' => $pedido,
        ], 204);
    }
}
