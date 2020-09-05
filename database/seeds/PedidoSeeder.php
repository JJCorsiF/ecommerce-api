<?php

use App\Cliente;
use App\Pedido;
use App\Produto;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class PedidoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Pedido::truncate();
        Schema::enableForeignKeyConstraints();

        $faker = \Faker\Factory::create('pt_BR');

        for ($i = 0; $i < 5; $i++) {
            $pedido = Pedido::create([
                'id_cliente' => Cliente::inRandomOrder()->first()->id_cliente,
                'uuid_pedido' => $faker->uuid,
                'codigo_pedido' => Str::random(20),
                'data_pedido' => $faker->dateTimeThisYear(),
                'observacao' => Str::random(20),
                'forma_pagamento' => $faker->randomElement(['dinheiro', 'cartão', 'cheque',]),
            ]);

            $produtos = Produto::inRandomOrder()->limit($faker->numberBetween(1, 3))->get();

            foreach ($produtos as $produto) {
                $pedido->produtos()->save($produto, ['quantidade' => $faker->randomDigitNot(0),]);
            }
        }
    }
}
