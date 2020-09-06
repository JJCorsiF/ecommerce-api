<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Mail\PedidoRealizado;
use App\Pedido;
use App\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use PDF;

class PedidoController extends Controller
{
    public function listarPedidos()
    {
        $pedidos = Pedido::with('produtos')->get();

        return response()->json([
            'pedidos' => $pedidos,
        ], 200);
    }

    public function buscarPedido($id)
    {
        $pedido = Pedido::with('produtos')->where('id_pedido', $id)->orWhere('uuid_pedido', $id)->firstOrFail();

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
                $produto = Produto::where('id_produto', $idDoProduto)->orWhere('uuid_produto', $idDoProduto)->firstOrFail();

                $pedido->produtos()->save($produto, ['quantidade' => $produtoDoPedido['quantidade'],]);
            }

            return response()->json([
                'pedido' => $pedido,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => utf8_encode($e->getMessage()),
            ], 500);
        }
    }

    public function atualizarPedido(Request $request, $id)
    {
        try {
            $pedido = Pedido::where('id_pedido', $id)->orWhere('uuid_pedido', $id)->firstOrFail();

            $pedido->update($request->all());

            $produtos = $request->produtos;

            $produtosAtualizados = [];

            foreach ($produtos as $produto) {
                $produtosAtualizados[$produto['id_produto']] = ['quantidade' => $produto['quantidade'],];
            }

            $pedido->produtos()->sync($produtosAtualizados);

            return response()->json([
                'pedido' => Pedido::with('produtos')->where('id_pedido', $id)->orWhere('uuid_pedido', $id)->firstOrFail(),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => utf8_encode($e->getMessage()),
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

    public function enviarPedidoPorEmail($id)
    {
        $pedidoComProdutos = Pedido::with('produtos')->where('id_pedido', $id)->orWhere('uuid_pedido', $id)->firstOrFail();

        $cliente = Cliente::where('id_cliente', $pedidoComProdutos->id_cliente)->first();

        Mail::to($cliente->email)->send(new PedidoRealizado($pedidoComProdutos, $cliente));

        return response()->json([
            'mensagem' => 'Email enviado com sucesso.',
            'pedido' => $pedidoComProdutos,
        ], 200);
    }

    public function gerarPedidoEmPdf($id)
    {
        $pedidoComProdutos = Pedido::with('produtos')->where('id_pedido', $id)->orWhere('uuid_pedido', $id)->firstOrFail();
        $cliente = Cliente::where('id_cliente', $pedidoComProdutos->id_cliente)->first();

        $data = ['title' => 'Seu pedido', 'pedido' => $pedidoComProdutos, 'cliente' => $cliente,];
        $pdf = PDF::loadView('mail-template', $data);

        return $pdf->download('relatorio-pedido-' . $pedidoComProdutos->uuid_pedido . '.pdf');
    }
}
