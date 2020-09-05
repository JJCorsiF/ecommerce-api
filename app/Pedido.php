<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    // const CREATED_AT = 'data_criacao';
    // const UPDATED_AT = 'ultima_atualizacao';

    protected $fillable = ['id_cliente', 'uuid_pedido', 'codigo_pedido', 'data_pedido', 'observacao', 'forma_pagamento',];

    protected $primaryKey = 'id_pedido';

    public function produtos()
    {
        return $this->belongsToMany('App\Produto', 'produtos_pedido', 'id_pedido', 'id_produto')->withPivot('quantidade');
    }
}
