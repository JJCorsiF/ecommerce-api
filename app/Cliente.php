<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = ['id_cliente', 'codigo_cliente', 'nome', 'cpf', 'sexo', 'email',];
}
