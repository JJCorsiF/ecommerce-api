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
}
