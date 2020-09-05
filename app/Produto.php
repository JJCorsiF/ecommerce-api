<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    // const CREATED_AT = 'data_criacao';
    // const UPDATED_AT = 'ultima_atualizacao';
    // const DELETED_AT = 'deletado_em';

    protected $fillable = ['uuid_produto', 'codigo_produto', 'nome', 'cor', 'tamanho', 'valor',];

    protected $primaryKey = 'id_produto';

    public function pedidos()
    {
        return $this->belongsToMany('App\Pedido', 'produtos_pedido', 'id_produto', 'id_pedido')->withPivot('quantidade');
    }
}
