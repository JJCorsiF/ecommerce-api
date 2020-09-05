<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Produto;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Produto::class, function (Faker $faker) {
    return [
        'uuid_produto' => $faker->uuid,
        'codigo_produto' => Str::random(20),
        'nome' => 'produto ' . $faker->name,
        'cor' => $faker->safeColorName,
        'tamanho' => $faker->randomElement(['pequeno', 'médio', 'grande',]),
        'valor' => $faker->biasedNumberBetween(),
    ];
});
