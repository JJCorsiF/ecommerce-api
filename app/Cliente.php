<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    // const CREATED_AT = 'data_criacao';
    // const UPDATED_AT = 'ultima_atualizacao';
    // const DELETED_AT = 'deletado_em';

    protected $fillable = ['uuid_cliente', 'codigo_cliente', 'nome', 'cpf', 'sexo', 'email',];

    protected $primaryKey = 'id_cliente';
}
