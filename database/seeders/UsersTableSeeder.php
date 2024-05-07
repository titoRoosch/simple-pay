<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('pt_BR');
        DB::table('users')->insert([
            'name' => 'Administrador',
            'email' => 'admin@example.com',
            'role' => 'super',
            'password' => Hash::make('password'),
            'document' => $faker->cpf(false),
        ]);
    }
}

