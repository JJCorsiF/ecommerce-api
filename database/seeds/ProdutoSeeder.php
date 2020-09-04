<?php

use App\Produto;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProdutoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Produto::truncate();

        $faker = \Faker\Factory::create('pt_BR');

        for ($i = 0; $i < 50; $i++) {
            Produto::create([
                'uuid_produto' => $faker->uuid,
                'codigo_produto' => Str::random(20),
                'nome' => 'produto ' . $faker->name,
                'cor' => $faker->safeColorName,
                'tamanho' => $faker->randomElement(['pequeno', 'médio', 'grande',]),
                'valor' => $faker->biasedNumberBetween(),
            ]);
        }
    }
}
