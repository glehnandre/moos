<?php

use Illuminate\Database\Seeder;
use App\Credito;

class CreditosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         // Let's truncate our existing records to start from scratch.
        Credito::truncate();

        $faker = \Faker\Factory::create();

        // And now, let's create a few articles in our database:
        for ($i = 0; $i < 50; $i++) {
            Credito::create([
                'cpf' => $faker->unique()->randomNumber(11, false),
                'nome' => $faker->name,
                'cartao' => $faker->randomElement(["1234567", "9994732"]),
                'transacao' => $faker->randomElement(["Cartão", "Dinheiro"]),
                'bandeira' => $faker->null,
                'saldo' => $faker->numberBetween(10, 1000) ,
                'credito' => $faker->numberBetween(10, 1000),
                'terminal' => $faker->numberBetween(10, 1000),
                'latitude' => $faker->randomFloat,
                'longitude' => $faker->randomFloat,
                'data_transacao' => $faker->dateTime,
                'id_transacao' => $faker->unique()->randomNumber(11, false),
            ]);
        }
    }
}
