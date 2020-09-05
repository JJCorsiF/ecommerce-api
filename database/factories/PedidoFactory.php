<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Cliente;
use App\Pedido;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Pedido::class, function (Faker $faker) {
    return [
        'id_cliente' => Cliente::inRandomOrder()->first()->id_cliente,
        'uuid_pedido' => $faker->uuid,
        'codigo_pedido' => Str::random(20),
        'data_pedido' => $faker->dateTimeThisYear(),
        'observacao' => Str::random(20),
        'forma_pagamento' => $faker->randomElement(['dinheiro', 'cartão', 'cheque',]),
    ];
});
