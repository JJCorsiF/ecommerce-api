<?php

use App\Cliente;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Cliente::truncate();
        Schema::enableForeignKeyConstraints();

        $faker = \Faker\Factory::create('pt_BR');

        for ($i = 0; $i < 5; $i++) {
            $sexo = $faker->randomElement(['masculino', 'feminino']);

            Cliente::create([
                'uuid_cliente' => $faker->uuid,
                'codigo_cliente' => Str::random(20),
                'nome' => $faker->name($sexo),
                'cpf' => $faker->cpf(false),
                'sexo' => $sexo,
                'email' => $faker->safeEmail,
            ]);
        }
    }
}
