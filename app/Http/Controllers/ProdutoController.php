<?php

namespace App\Http\Controllers;

use App\Produto;
use Illuminate\Http\Request;

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
}
