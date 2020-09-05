<?php

namespace App\Http\Controllers;

use App\Pedido;
use Illuminate\Http\Request;

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
}
