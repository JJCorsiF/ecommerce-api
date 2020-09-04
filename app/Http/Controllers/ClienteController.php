<?php

namespace App\Http\Controllers;

use App\Cliente;

class ClienteController extends Controller
{
    public function listarClientes()
    {
        return Cliente::all();
    }
}
