<?php

namespace App\Http\Controllers;

use App\Cliente;

class ClienteController extends Controller
{
    public function listarClientes()
    {
        return Cliente::all();
    }

    public function buscarCliente($id)
    {
        return Cliente::where('id_cliente', $id)->first();
    }
}
