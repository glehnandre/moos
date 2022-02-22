<?php

use Illuminate\Database\Seeder;
use MooS\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'admin',
                'display_name' => 'Administrator',
                'description' => 'User has access to all system functionality'
            ],
            [
                'name' => 'cliente',
                'display_name' => 'Cliente',
                'description' => 'Usuário do MooS'
            ],
            [
                'name' => 'gestor',
                'display_name' => 'Gestor',
                'description' => 'Gestor do evento ou estabelecimento'
            ]
        ];

        foreach ($roles as $key => $value) {
            Role::create($value);
        }
    }
}