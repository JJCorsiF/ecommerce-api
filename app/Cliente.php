<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = ['uuid_cliente', 'codigo_cliente', 'nome', 'cpf', 'sexo', 'email',];
}
