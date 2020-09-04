<?php

namespace App\Http\Controllers;

use App\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProdutoController extends Controller
{
    public function listarProdutos()
    {
        $produtos = Produto::all();

        return response()->json([
            'produtos' => $produtos,
        ], 200);
    }

    public function buscarProduto($id)
    {
        $produto = Produto::where('id_produto', $id)->first();

        return response()->json([
            'produto' => $produto,
        ], 200);
    }

    public function adicionarProduto(Request $request)
    {
        try {
            $produtoAAdicionar = $request->produto;

            $produto = Produto::create([
                'uuid_produto' => Str::uuid(),
                'codigo_produto' => $produtoAAdicionar['codigo_produto'],
                'nome' => $produtoAAdicionar['nome'],
                'cor' => $produtoAAdicionar['cor'],
                'tamanho' => $produtoAAdicionar['tamanho'],
                'valor' => $produtoAAdicionar['valor'],
            ]);

            return response()->json([
                'produto' => $produto,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function atualizarProduto(Request $request, $id)
    {
        $produto = Produto::where('id_produto', $id)->firstOrFail();
        $produto->update($request->all());

        return response()->json([
            'produto' => $produto,
        ], 200);
    }
}
