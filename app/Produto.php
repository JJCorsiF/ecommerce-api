<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    // const CREATED_AT = 'data_criacao';
    // const UPDATED_AT = 'ultima_atualizacao';

    protected $fillable = ['uuid_produto', 'codigo_produto', 'nome', 'cor', 'tamanho', 'valor',];

    protected $primaryKey = 'id_produto';
}