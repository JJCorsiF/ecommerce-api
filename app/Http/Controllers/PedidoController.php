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
}
