<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Cliente;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Cliente::class, function (Faker $faker) {
    $sexo = $faker->randomElement(['masculino', 'feminino']);

    return [
        'id_cliente' => $faker->uuid,
        'codigo_cliente' => Str::random(10),
        'nome' => $faker->name($sexo),
        'cpf' => $faker->cpf(false),
        'sexo' => $sexo,
        'email' => $faker->safeEmail,
    ];
});
