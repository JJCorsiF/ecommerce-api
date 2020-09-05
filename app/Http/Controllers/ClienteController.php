<?php

namespace App\Http\Controllers;

use App\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ClienteController extends Controller
{
    public function listarClientes()
    {
        $clientes = Cliente::all();

        return response()->json([
            'clientes' => $clientes,
        ], 200);
    }

    public function buscarCliente($id)
    {
        $cliente = Cliente::where('id_cliente', $id)->orWhere('uuid_cliente', $id)->first();

        return response()->json([
            'cliente' => $cliente,
        ], 200);
    }

    public function adicionarCliente(Request $request)
    {
        try {
            $clienteAAdicionar = $request->cliente;

            $cliente = Cliente::create([
                'uuid_cliente' => Str::uuid(),
                'codigo_cliente' => $clienteAAdicionar['codigo_cliente'],
                'nome' => $clienteAAdicionar['nome'],
                'cpf' => $clienteAAdicionar['cpf'],
                'sexo' => $clienteAAdicionar['sexo'],
                'email' => $clienteAAdicionar['email'],
            ]);

            return response()->json([
                'cliente' => $cliente,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function atualizarCliente(Request $request, $id)
    {
        $cliente = Cliente::where('id_cliente', $id)->orWhere('uuid_cliente', $id)->firstOrFail();
        $cliente->update($request->all());

        return response()->json([
            'cliente' => $cliente,
        ], 200);
    }

    public function deletarCliente($id)
    {
        $cliente = Cliente::where('id_cliente', $id)->orWhere('uuid_cliente', $id)->firstOrFail();
        $cliente->delete();

        return response()->json([
            'cliente' => $cliente,
        ], 204);
    }
}
